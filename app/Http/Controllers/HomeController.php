<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\JobPost;
use App\Models\Location;
use App\Models\CompanyProfile;
use Inertia\Inertia;
use Mail; 

class HomeController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth',['except' => ['home','jobs','companies','blog','hiring']]);
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
                    'role' => $user->role,
                    'is_email_verified' => $user->is_email_verified
                ],
            ]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function home(){
        $job_posts = JobPost::count();
        $locations = Location::get();
        return Inertia::render('home',['count_job_posts'=>$job_posts,'locations'=>$locations]);
    }

    public function blog(){
        return Inertia::render('blog');
    }

    public function companies(){
        return Inertia::render('companies');
    }

    public function jobs(Request $request){
        
        try{
            $job_posts_query = JobPost::join('company_profiles','job_posts.company_profile_id','company_profiles.id')
            ->join('locations', 'job_posts.location_id', 'locations.id')
            ->select(
                    'job_posts.name as name',
                    'job_posts.content as content',
                    'company_profiles.name as company_name',
                    'job_posts.apply_url as apply_url',
                    'company_profiles.slug as company_slug',
                    'locations.name as location',
                    'job_posts.slug as job_slug',
                    'job_posts.created_at'
            )->when($request->q, function($query, $term) {
                    $query->where('job_posts.name', 'LIKE', '%'.$term.'%');
                    $query->where('job_posts.content', 'LIKE', '%'.$term.'%');
            })->when($request->loc, function($query, $term1) {
                $query->where('job_posts.location_id', $term1);
            })
            ->orderBy('job_posts.created_at','DESC');

            $job_posts = $job_posts_query->paginate($this->paginationLimit);

            $job_posts_count = $job_posts_query->count();
            //->paginate($this->paginationLimit);
            
            //die('');
            $locations = Location::get();
            return Inertia::render('job_posts', ['job_posts' => $job_posts,'job_posts_count'=>$job_posts_count,'loc_id'=>$request->loc,'location_id'=>$request->loc,'term'=>$request->q,'locations'=>$locations]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function hiring(Request $request){
        
        try{
            $company = CompanyProfile::with('job_posts')->leftjoin('locations','company_profiles.location_id','locations.id')
            //->join('users','company_profiles.user_id','=','users.id')
            ->select(
                'company_profiles.id',
                //'company_profiles.user_id',
                'company_profiles.name',
                'company_profiles.mission',
                'company_profiles.name',
                'locations.name as location',
                'company_profiles.local_employees',
                'company_profiles.global_employees',
                'company_profiles.year_founded',
                'company_profiles.website_url',
                'company_profiles.created_at',
                'company_profiles.industry_ids',
                'company_profiles.logo_image_url',
                'company_profiles.street_addr_1',
                'company_profiles.city',
                'company_profiles.uuid',
                'company_profiles.unclaimed',
                'company_profiles.slug',
                //'users.role',
            )
            ->paginate($this->paginationLimit);
            /*if(Auth::check())
            {
                if($company->user_id == Auth::id())
                {
                    $company->unclaimed = 0;
                }
            }*/
            //$selected_industries = explode(',',$company['industry_ids']);
           
            /*$industries = CompanyType::whereIn('id', $selected_industries)->pluck('name')->toArray();
            $company['industry_types'] = implode(' | ',$industries);
            
            $company['logo_image_url'] = ($company['logo_image_url']) ? getBucketImageUrl($company['uuid'],$company['logo_image_url'],'company') : '';
            */    
            /*$job_posts = JobPost::select('job_posts.*','company_profiles.slug as company_slug')->join('company_profiles','job_posts.company_profile_id','company_profiles.id')
            ->where('company_profile_id',$company['id'])->orderBy('id','DESC')->get()->toArray();
            
            $job_post_model = new JobPost();
            foreach($job_posts as $key => $job)
            {
                $job_posts[$key]['location_id'] = $job_post_model->getJobLocation($job['remotetype_id']);
                $job_posts[$key]['job_slug'] = $job['slug'];
            }    */
            //dd($company);
            return Inertia::render('hiring', ['data'=>$company]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function contact(){
        try{
            return Inertia::render('contact');

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function contactSubmit(Request $request){
        try{
            $data = $request->all();

            Mail::send('emails.contactForm',['data'=>$data], function($message){
                $message->to(env('ADMIN_EMAIL'));
                $message->subject(__('messages.contact_form_filled'));
            });

            return $this->sendSuccessResponse('thankyou',__('messages.contact_form_submit'),[]);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }
}
