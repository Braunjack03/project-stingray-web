<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;
use Exception;

class LoadArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:article {article_file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load an Article';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $article = $this->argument('article_file');

        $object = YamlFrontMatter::parse(file_get_contents($article));

        $companies = $this->find_keywords($object->body());
        $u_companies = array_unique($companies[0]);
        $slugs = str_replace(["{{", "}}"], "", $u_companies);

        $body =  $object->body();
        foreach ($slugs as $c) {

            try{
            $company_profile = CompanyProfile::where('slug', $c)->first();
            } catch(Exception $e) {
                print("Caught exception" . $e->getMessage() . "\n");
                dd($c);

            }
            $name = $company_profile->name;
            $com = "{{{$c}}}";
            $body = str_replace($com, "<a class=\"underline\" href=\"/companies/$c\">$name</a>", $body);
        }

        $post = new Article;

        $post->title = $object->title;
        $post->sub_title = $object->sub_title;

        $header_image = Storage::disk('s3Company')->putFileAs('article/images/', __DIR__ . "/../../../articles/images/" . $object->header_image, $object->header_image);
        $post->header_image = "https://ik.imagekit.io/stingray/article/images/" . $object->header_image;
        $post->slug = Str::of($object->title . " " . rand(0, 100))->slug('-');
        $post->content = $body;


        $post->author_id = $object->author_id;
        $post->is_published = 1;
        $post->created_at = now();
        $post->publish_date = now();
        $post->save();

        foreach ($object->tags as $tag_name) {

            $tag = Tag::where('name', $tag_name)->first();
            $post->tags()->syncWithoutDetaching($tag);
        }

        foreach ($slugs as $c) {
            try {
                $company_profile = CompanyProfile::where('slug', $c)->first();
            } catch (Exception $e) {
                print("Caught exception" . $e->getMessage() . "\n");
                dd($c);
            }
            $post->company_profiles()->syncWithoutDetaching($company_profile);
        }

        print("Article Uploaded");

        return 0;
    }

    public function find_keywords($text)
    {
        $pattern = '/{{[a-zA-Z0-9-_]+}}/';
        if (preg_match_all($pattern, $text, $matches)) {
            print_r($matches);
            return $matches;
        }
    }
}
