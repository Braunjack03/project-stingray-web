<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\JobPost;
use Inertia\Inertia;

class HomeController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth',['except' => ['home']]);
    }
    /**
     * Dashboard
     *
     * @return \Illuminate\View\View
     */

    public function index(){
        
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        try{
            $user = Auth::user();
            return Inertia::render('dashboard', [
                'user' => [
                    'email' => $user->email,
                    'name' => $user->email,
                    'is_email_verified' => $user->is_email_verified
                ],
            ]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function home(){

        $job_posts = JobPost::join('company_profiles','job_posts.company_profile_id','company_profiles.id')
        ->select(
                 'job_posts.name as name',
                 'job_posts.content as content',
                 'company_profiles.name as company_name',
                 'job_posts.apply_url as apply_url',
                 'company_profiles.slug as company_slug',
                 'job_posts.slug as job_slug'
         )
        ->get();
        return Inertia::render('job_posts', ['job_posts' => $job_posts]);
    }
}
