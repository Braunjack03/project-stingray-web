<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\CompanyProfile;
use App\Models\CompanyType;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Redirect;
use App\Models\ActivityLog;
use Session;
use Mail; 

class CompanyProfileController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','employer'],['except' => ['showCompany']]);
    }
    
      /**
     * To view company profile form
     *
     * @return \Illuminate\View\View
     */
    public function create(){
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        try{
            $user = Auth::user();
            $industries = CompanyType::pluck('name','id');
            return Inertia::render('employer/create-company',['industries'=>$industries]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

     /**
     * To register company profile
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request){        
          
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        $data = $request->except(['logo_image_src']);
        $user_id = Auth::id();
       
        $data['user_id'] = $user_id;
        
        $redirect_page = $request->path();
        $company_profile_count = CompanyProfile::where('user_id',$user_id)->count();
        if($company_profile_count >= 3)
        {
             return Redirect::route('employer.profile');
        }   

        $messages = [
            'max' => 'The company logo must not be greater than 1 MB',
            'name.required' => 'Company name is required',
        ]; 
      
        $validator = Validator::make($data, [
            'name' => 'required',
            'local_employees' => 'nullable|numeric',
            'global_employees' => 'nullable|numeric',
            'logo_image_url' => 'nullable|mimes:jpeg,png,jpg,gif|max:1000',
        ],$messages);
        
        if ($validator->fails()){
            $industries = CompanyType::pluck('name','id');
            //$data['industry'] = explode(",",$data['industry']);
            $data = ['user'=>$data,'industries'=>$industries];
            return $this->sendCustomValidationErrorsWithData($redirect_page,$validator->errors(),$data);
        }else{
            try{
                $user_uuid = Str::uuid();
                
                $profile_image = '';
                $image_name = '';
                if ($image = $request->file('logo_image_url')) {
                    $image_name = time() . '_' . $image->getClientOriginalName();
                    $profile_image = Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $image,$image_name);
                }
                if(isset($data['industry']))
                {   
                    $data['industry_ids'] = isset($data['industry']) ? implode(',',$data['industry']) : $data['industry'];
                }
                $data['uuid'] = $user_uuid;    
                $data['logo_image_url'] = $image_name;

                if(!$request->file('logo_image_url') && (isset($data['logo_image_removed']) && $data['logo_image_removed'] == 0))
                {
                    unset($data['logo_image_removed']);
                }
                $data['slug'] = $this->createCompanySlug($data['name']);
                CompanyProfile::create($data);
               
                ActivityLog::addToLog(__('activitylogs.company_profile_created'),'company created');
                return Redirect::route('employer.profile')->with( ['message' => __('messages.company_profile_created')] );
                 
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

    public function edit(Request $request){

        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        try{
            $user = CompanyProfile::where('uuid',$request->all()['id'])->first();
            if($user)
            {
                if(!empty($user->industry_ids))
                {
                    $user->industry_ids = explode(",",$user->industry_ids);
                }else{
                    $user->industry_ids = [];

                }
                
                $user->logo_image_src = ($user->logo_image_url) ? getBucketImageUrl($request->all()['id'],$user->logo_image_url,'company') : '';

            }
            $industries = CompanyType::pluck('name','id');
            $data = ['user'=>$user,'industries'=>$industries];
            return $this->sendResponseWithData('employer/edit-company','',$data);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    /**
     * To register job seeker or employer
     *
     * @return \Illuminate\View\View
     */
    public function update(Request $request){        
          
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        $requested_data = $request->except(['logo_image_src']);
    
        $user = CompanyProfile::where('uuid',$request->all()['id'])->first();
        $user_uuid = $request->all()['id'];
        $redirect_page = $request->path();
       
        $data = [
            "name"=>isset($requested_data['name']) ? $requested_data['name'] : '',
            'user_id' => Auth::id(),
            'uuid' => $user_uuid,
            'local_employees' => isset($requested_data['local_employees']) ? $requested_data['local_employees'] : '',
            'global_employees' => isset($requested_data['global_employees']) ? $requested_data['global_employees'] : '',
            'website_url' => isset($requested_data['website_url']) ? $requested_data['website_url'] : '',
            'mission' => isset($requested_data['mission']) ? $requested_data['mission'] : '',
            'industry_ids' => (isset($requested_data['industry_ids']) && is_array($requested_data['industry_ids'])) ? implode(',',$requested_data['industry_ids']) : $requested_data['industry_ids'],
            'street_addr_1' => isset($requested_data['street_addr_1']) ? $requested_data['street_addr_1'] : '',
            'street_addr_2' => isset($requested_data['street_addr_2']) ? $requested_data['street_addr_2'] : '',
            'city' => isset($requested_data['city']) ? $requested_data['city'] : '',
            'postcode' => isset($requested_data['postcode']) ? $requested_data['postcode'] : '',
            'state_abbr' => isset($requested_data['state_abbr']) ? $requested_data['state_abbr'] : '',
            'linkedin_user' => isset($requested_data['linkedin_user']) ? $requested_data['linkedin_user'] : '',
            'facebook_user' => isset($requested_data['facebook_user']) ? $requested_data['facebook_user'] : '',
            'twitter_user' => isset($requested_data['twitter_user']) ? $requested_data['twitter_user'] : '',
            'instagram_user' => isset($requested_data['instagram_user']) ? $requested_data['instagram_user'] : '',
            'logo_image_removed' => isset($requested_data['logo_image_removed']) ? $requested_data['logo_image_removed'] : '',
        ];

        $messages = [
            'max' => 'The company logo must not be greater than 1 MB',
            'name.required' => 'Company name is required',
        ]; 
       
        $validator = Validator::make($data, [
            'name' => 'required',
            'local_employees' => 'nullable|numeric',
            'global_employees' => 'nullable|numeric',
            'logo_image_url' => 'mimes:jpeg,png,jpg,gif|max:1000|nullable'
        ],$messages);
        
        if ($validator->fails()){
            $industries = CompanyType::pluck('name','id');
            $data['industry_ids'] = explode(",",$data['industry_ids']);
            $user_data = ['user'=>$data,'industries'=>$industries];
            return $this->sendCustomValidationErrorsWithData($redirect_page,$validator->errors(),$user_data);
        }else{
            try{
                $profile_image = '';
                $image_name = '';
                if ($image = $request->file('logo_image_url')) {
                    $image_name = time() . '_' . $image->getClientOriginalName();
                    $profile_image = Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $image,$image_name);
                }
                
                $profile_data = [
                    "name"=>$data['name'],
                    'user_id' => $data['user_id'],
                    'local_employees' => $data['local_employees'],
                    'global_employees' => $data['global_employees'],
                    'website_url' => $data['website_url'],
                    'mission' => $data['mission'],
                    'industry_ids' =>  ltrim($data['industry_ids'], ','),
                    'street_addr_1' => $data['street_addr_1'],
                    'street_addr_2' => $data['street_addr_2'],
                    'city' => $data['city'],
                    'postcode' => $data['postcode'],
                    'state_abbr' => $data['state_abbr'],
                    'linkedin_user' => $data['linkedin_user'],
                    'facebook_user' => $data['facebook_user'],
                    'twitter_user' => $data['twitter_user'],
                    'instagram_user' => $data['instagram_user'],
                    'logo_image_url' => $image_name,
                    'slug' => $this->createCompanySlug($data['name']),
                ];
                
                if(!$request->file('logo_image_url') && (isset($data['logo_image_removed']) && $data['logo_image_removed'] == 0))
                {
                    unset($profile_data['logo_image_url']);
                }
                $user = CompanyProfile::where('uuid',$requested_data['id'])->update($profile_data);
                ActivityLog::addToLog(__('activitylogs.company_profile_updated'),'company updated');
                return redirect()->route('employer.profile')->with(['message' => __('messages.company_profile_updated')]);
     
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

    public function createCompanySlug($title)
    {
        // Normalize the title
        $slug = Str::slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)){
            return $slug;
        }
    // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
    }

    protected function getRelatedSlugs($slug)
    {
        return CompanyProfile::select('slug')->where('slug', 'like', $slug.'%')->get();
    }

    public function showCompany($slug = ''){

        try{
            $company = CompanyProfile::with('job_posts')->leftjoin('locations','company_profiles.location_id','locations.id')
            //->join('users','company_profiles.user_id','=','users.id')
            ->select(
                'company_profiles.id',
                //'company_profiles.user_id',
                'company_profiles.name',
                'company_profiles.mission',
                'company_profiles.description',
                'company_profiles.name',
                'locations.name as location',
                'company_profiles.local_employees',
                'company_profiles.global_employees',
                'company_profiles.year_founded',
                'company_profiles.website_url',
                'company_profiles.created_at',
                'company_profiles.industry_ids',
                'company_profiles.logo_image_url',
                'company_profiles.state_abbr as state',
                'company_profiles.city',
                'company_profiles.uuid',
                'company_profiles.unclaimed',
                'company_profiles.slug',
                //'users.role',
            )
            ->where('company_profiles.slug',$slug)->first();
            /*if(Auth::check())
            {
                if($company->user_id == Auth::id()) 
                {
                    $company->unclaimed = 0;
                }
            }*/
            $selected_industries = explode(',',$company['industry_ids']);
           
            $industries = CompanyType::whereIn('id', $selected_industries)->pluck('name')->toArray();
            $company['industry_types'] = implode(' | ',$industries);
            
            $company['logo_image_url'] = ($company['logo_image_url']) ? getBucketImageUrl($company['uuid'],$company['logo_image_url'],'company') : '';

            $job_posts = JobPost::select('job_posts.*','company_profiles.slug as company_slug')
            ->leftjoin('company_profiles','job_posts.company_profile_id','company_profiles.id')
            ->where('company_profile_id',$company['id'])->orderBy('id','DESC')->take(5)->get()->toArray();
            
            $job_post_model = new JobPost();
            foreach($job_posts as $key => $job)
            {
                $job_posts[$key]['location_id'] = $job_post_model->getJobLocation($job['remotetype_id']);
                $job_posts[$key]['job_slug'] = $job['slug'];
            }    
            
            return Inertia::render('single-company',['data'=>$company,'job_posts'=>$job_posts,'industries',$industries]);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function claimProfile($id = ''){   
       try{
            //$status = CompanyProfile::where('uuid',$id)->update(['unclaimed'=>0]);
            ActivityLog::addToLog(__('activitylogs.company_profile_updated'),'company claimed');
            $user = CompanyProfile::join('users','company_profiles.user_id','=','users.id')
            ->select('company_profiles.name as company_name','users.name','users.email')
            ->where('company_profiles.uuid',$id)->first();  
            Mail::send('emails.claimCompanyProfile',['user'=>$user], function($message){
                $message->to(env('ADMIN_EMAIL'));
                $message->subject(__('messages.profile_claimed'));
            });
            return redirect()->back()->with(['message' => __('messages.company_claimed')]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }
}