<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\JobPost;
use App\Models\CompanyProfile;
use App\Models\Location;
use Inertia\Inertia;

class AdminController extends Controller
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
            return Inertia::render('admin/dashboard', [
                'user' => [
                    'email' => $user->email,
                    'name' => $user->email,
                    'role' => $user->role,
                    'is_email_verified' => $user->is_email_verified,
                    'jobs_count' => JobPost::count(),
                    'companies_count' => CompanyProfile::count(),
                ],
            ]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function jobs(Request $request){
        
        try{
            $job_posts = JobPost::join('company_profiles','job_posts.company_profile_id','company_profiles.id')
            ->select(
                    'job_posts.id as job_id',
                    'job_posts.name as name',
                    'job_posts.content as content',
                    'company_profiles.name as company_name',
                    'job_posts.apply_url as apply_url',
                    'company_profiles.slug as company_slug',
                    'job_posts.slug as job_slug',
                    'job_posts.created_at'
            )
            ->orderBy('job_posts.created_at','DESC')
            ->paginate($this->paginationLimit);
            $locations = Location::get();
            return Inertia::render('admin/job_posts', ['job_posts' => $job_posts]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function companies(Request $request){
        
        try{
            $companies = CompanyProfile::orderBy('created_at','DESC')
            ->paginate($this->paginationLimit);
            $locations = Location::get();
            return Inertia::render('admin/companies_listing', ['companies' => $companies]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }
}
