<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\CompanyProfile;
use Inertia\Inertia;
use Carbon\Carbon;

class ArticleController extends Controller
{

    public function index(){

        try{
            // TODO order by publish_date not article id.
            // TODO don't select * from articles
            $article = Article::with('tags')->select('articles.id','articles.slug','articles.header_image','articles.title','articles.content','articles.publish_date'
            ,'users.id as author_id','users.name as author_name')
            ->leftjoin('users','articles.author_id','users.id')->where('is_published',1)
            ->orderBy('articles.publish_date','DESC')->first();

            // TODO order by publish_date
            // TODO don't do a select * from articles.  This sends all data to the frontend where it's publically visable.
            $latestarticles = Article::select('articles.id','articles.slug','articles.header_image','articles.title','articles.content','articles.publish_date','users.id as author_id','users.name  as author_name')
            ->leftjoin('users','articles.author_id','users.id')
            ->whereNotIn('articles.id', [$article->id])
            ->where('is_published',1)
            ->with('tags')
            ->orderBy('articles.publish_date','DESC')->paginate(9)->onEachSide(0);
            
            return Inertia::render('article',['latest'=>$article,'articles'=>$latestarticles])->withViewData(['meta' => 1,"metaTitle" => "News - Made in Tampa","metaDescription" => "Made in Tampa News"]);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('404',$message);
        }
    }

    public function show($slug = ''){

        try{
            // Don't do a select * from articles
            $data = Article::select('articles.id','articles.sub_title','articles.slug','articles.header_image','articles.title','articles.content','articles.publish_date'
            ,'users.id as author_id','users.name as author_name')->leftjoin('users','articles.author_id','users.id')
            ->with('tags')
            ->where('is_published',1)->where('articles.slug',$slug)->first();

            $companies = CompanyProfile::select('company_profiles.name','company_profiles.logo_image_url','company_profiles.uuid','company_profiles.description','company_profiles.slug','company_profiles.city','company_profiles.state_abbr as state')
            ->leftjoin('article_company_profile','company_profiles.id','=','article_company_profile.company_profile_id')->where('article_company_profile.article_id', $data->id)->withCount('job_posts')->paginate(3);
            
            $companies_data = [];
            foreach ($companies as $key => $comp) {
                if (!str_starts_with($companies[$key]['logo_image_url'], 'https://')) {
                    $companies[$key]['logo_image_url'] = ($comp['logo_image_url']) ? getBucketImageUrl($comp['uuid'], $comp['logo_image_url'], 'company') : '';
                }
            }
            $companies_data = $companies;
            $meta = [
                'meta' => 1,
                "metaTitle" => "Made in Tampa - Article",
                "metaArticle" => 1,
                "metaArticleURL" => url('articles/'.$data->slug),
                "metaArticleTitle" => $data->title,
                "metaArticleDescription" => substr(strip_tags($data->content), 0, 128),
                "metaArticleImageURL" => ($data->header_image)?$data->header_image:url('/images/news-author-01.png'),
            ];
            return Inertia::render('single-article',['data'=>$data,'articles'=>$companies_data])->withViewData($meta);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('404',$message);
        }
    }
}
