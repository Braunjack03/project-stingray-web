<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Inertia\Inertia;

class ArticleController extends Controller
{

    public function index(){

        $article = Article::with('tags')->select('articles.*','users.id as author_id','users.name')->leftjoin('users','articles.author_id','users.id')->orderBy('articles.id','DESC')->first();
        $latestarticles = Article::with('tags')->leftjoin('users','articles.author_id','users.id')->whereNotIn('articles.id', [$article->id])->orderBy('articles.id','DESC')->paginate(9)->onEachSide(1);
        
        return Inertia::render('article',['latest'=>$article,'articles'=>$latestarticles]);
    }

    public function show($slug = ''){

        $data = Article::with('tags')->select('articles.*','users.id as author_id','users.name')->leftjoin('users','articles.author_id','users.id')->where('articles.slug',$slug)->first();
      
        $latestarticles = Article::with('tags')->leftjoin('users','articles.author_id','users.id')->where('articles.id','!=', $data->id)->orderBy('articles.id','DESC')->take(3)->get();


        return Inertia::render('single-article',['data'=>$data,'articles'=>$latestarticles]);
    }
}
