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
            $article = Article::with('tags')->select('articles.*','users.id as author_id','users.name')->leftjoin('users','articles.author_id','users.id')->where('is_published',1)->orderBy('articles.id','DESC')->first();
        
            $latestarticles = Article::with('tags')->select('articles.*','users.id as author_id','users.name')->leftjoin('users','articles.author_id','users.id')->whereNotIn('articles.id', [$article->id])->where('is_published',1)->orderBy('articles.id','DESC')->paginate(9)->onEachSide(1);
            
            return Inertia::render('article',['latest'=>$article,'articles'=>$latestarticles]);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('404',$message);
        }
    }

    public function show($slug = ''){

        try{
            $data = Article::with('tags')->select('articles.*','users.id as author_id','users.name')->leftjoin('users','articles.author_id','users.id')->where('is_published',1)->where('articles.slug',$slug)->first();

            $latestarticles = CompanyProfile::withCount('job_posts')->leftjoin('article_company_profile','company_profiles.id','=','article_company_profile.company_profile_id')->where('article_company_profile.article_id', $data->id)->paginate(3);
            //dd($latestarticles);
            
            return Inertia::render('single-article',['data'=>$data,'articles'=>$latestarticles]);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('404',$message);
        }
    }
}
