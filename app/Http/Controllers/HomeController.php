<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\JobPost;
use App\Models\Location;
use App\Models\CompanyProfile;
use App\Models\CompanyType;
use App\Models\Article;
use Inertia\Inertia;
use Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['home', 'jobs','contact','contactSubmit','privacy','pricing', 'terms', 'for_employers', 'about_us']]);
    }
    /**
     * Dashboard
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {

        if (!Auth::check()) {
            return $this->sendErrorResponse('login', __('messages.unauthorized'));
        }

        try {
            $user = Auth::user();
            return Inertia::render('dashboard', [
                'user' => [
                    'email' => $user->email,
                    'name' => $user->email,
                    'role' => $user->role,
                    'is_email_verified' => $user->is_email_verified
                ],
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }

    public function home()
    {
        $job_posts = JobPost::count();
        $locations = Location::select('id','name')->get();
        $companytypes = CompanyType::select('id','name')->take(40)->get();
        
        $latestarticles = Article::select('articles.id','articles.slug','articles.header_image','articles.title','articles.content','articles.publish_date','users.id as author_id','users.name  as author_name')
        ->leftjoin('users','articles.author_id','users.id')
        ->where('is_published',1)
        ->with('tags')
        ->orderBy('articles.publish_date','DESC')->limit(3)->get();
        
        return Inertia::render('home', ['articles'=>$latestarticles,'count_job_posts' => $job_posts, 'locations' => $locations, 'companytypes' => $companytypes])->withViewData(['meta' => 1,"metaTitle" => "Home - Made in Tampa","metaDescription" => "Companies Hiring in the Tampa Bay"]);
    }
    
    public function contact()
    {
        return $this->static_page('contact')->withViewData(['meta' => 1,"metaTitle" => "Contact Us - Made in Tampa","metaDescription" => "Companies Hiring in the Tampa Bay"]);
    }

    public function about_us(){
        $is_logged_in = 0;
        if(Auth::user() != null){
            $is_logged_in = 1;
        }
        return Inertia::render('about_us', ['is_logged_in'=>$is_logged_in]);
       // return $this->static_page('about_us');
    }

    public function privacy(){
        return $this->static_page('privacy')->withViewData(['meta' => 1,"metaTitle" => "Privacy Policy - Made in Tampa","metaDescription" => "Companies Hiring in the Tampa Bay"]);
    }

    public function for_employers(){
        return $this->static_page('for_employers')->withViewData(['meta' => 1,"metaTitle" => "For Employers - Made in Tampa","metaDescription" => "Companies Hiring in the Tampa Bay"]);
    }

    public function pricing(){
        return $this->static_page('pricing')->withViewData(['meta' => 1,"metaTitle" => "Pricing - Made in Tampa","metaDescription" => "Companies Hiring in the Tampa Bay"]);
    }

    public function terms(){
        return $this->static_page('terms')->withViewData(['meta' => 1,"metaTitle" => "Terms and Conditions - Made in Tampa","metaDescription" => "Companies Hiring in the Tampa Bay"]);
    }

    private function static_page($name){
        try {
            return Inertia::render($name);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('404', $message);
        }

    }

    public function contactSubmit(Request $request)
    {
        try {
            $data = $request->all();
            Mail::send('emails.contactForm', ['data' => $data], function ($message) use ($data) {
                $message->to(env('ADMIN_EMAIL'));
                $message->subject($data['subject']);
            });

            return $this->sendSuccessResponse('contact', __('messages.contact_form_submit'), []);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }
}
