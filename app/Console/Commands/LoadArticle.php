<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\CompanyProfile;
use App\Models\Tag;


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

        $this->find_keywords($object->body());


        $post = new Article;
        $post->title = $object->title;
        $post->sub_title = $object->sub_title;
        $post->header_image = "https://ik.imagekit.io/stingray/article/test/" . $object->header_image;
        $post->slug = Str::of($object->title." ".rand(0, 100))->slug('-');
        $post->content = $object->body();
        $post->author_id = $object->author_id;
        $post->is_published = 1;
        $post->created_at = now();
        $post->publish_date = now();
        $post->save();

        $post_id = $post->id;

        #$company_profiles = CompanyProfile::inRandomOrder()->take(random_int(0,5))->get()->pluck('id');
        $company_profile = CompanyProfile::where('id', 1)->first();
        $post->company_profiles()->syncWithoutDetaching($company_profile);





        //var_dump($post);
        
        return 0;
    }

    public function find_keywords($text){
        $pattern = '/{{.*}}/';
        if(preg_match_all($pattern, $text, $matches)) {
            print_r($matches);
        }

    }
}
