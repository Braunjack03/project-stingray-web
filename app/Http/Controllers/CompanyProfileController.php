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
use App\Models\Subscription;
use App\Models\CompanyProfileCompanyType;
use App\Models\BenefitCat;
use App\Models\CompanyProfileBenefitCat;
use App\Models\CompanyProfileGallery;
use Session;
use Mail; 

class CompanyProfileController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','employer'],['except' => ['showCompany','companies']]);
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
            $planId = Subscription::where(['user_id'=>$user->user_id])->first();
            $job_posts_count = 0;
            if(!empty($planId)){
                $getPlanName = getPlanName($planId['stripe_plan'],$planId['ends_at']);
            }else{
              $getPlanName = ["name"=>"Free Plan","slot"=>"0"];  
            }
            $benefitCats = BenefitCat::pluck('name','id');
            return Inertia::render('employer/create-company',['industries'=>$industries,'plan_name'=>$getPlanName,'job_posts_count' => $job_posts_count,'benefitCats'=>$benefitCats])->withViewData(['meta' => 1,"metaTitle" => "Create Company | Made in Tampa","metaDescription" => ""]);
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

        $data = $request->except(['logo_image_src','featured_image_url','multi_image_url']);
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
            'description.required' => 'Company description is required',
        ]; 
      
        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
            'local_employees' => 'nullable|numeric',
            'global_employees' => 'nullable|numeric',
            'logo_image_url' => 'nullable|mimes:jpeg,png,jpg,gif|max:1000',
        ],$messages);
        
        if ($validator->fails()){
            $industries = CompanyType::pluck('name','id');
            $benefitCats = BenefitCat::pluck('name','id');
            $data = ['user'=>$data,'industries'=>$industries,'benefitCats'=>$benefitCats];
            return $this->sendCustomValidationErrorsWithData($redirect_page,$validator->errors(),$data);
        }else{
            try{
                $user_uuid = Str::uuid();
                
                $profile_image = '';
                $image_name = '';
                $headerimage_name = '';
                $featured_image = '';
                if ($image = $request->file('logo_image_url')) {
                    $image_name = time() . '_' . $image->getClientOriginalName();
                    $profile_image = Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $image,$image_name);
                }

                if ($headerimage = $request->file('featured_image_url')) {
                    $headerimage_name = time() . '_' . $headerimage->getClientOriginalName();
                    $featured_image = Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $headerimage,$headerimage_name);
                }

                
                $data['uuid'] = $user_uuid;    
                $data['logo_image_url'] = $image_name;
                $data['featured_image_url'] = $headerimage_name;

                if(!$request->file('logo_image_url') && (isset($data['logo_image_removed']) && $data['logo_image_removed'] == 0))
                {
                    unset($data['logo_image_removed']);
                }

                if(!$request->file('featured_image_url') && (isset($data['featured_image_removed']) && $data['featured_image_removed'] == 0))
                {
                    unset($data['featured_image_removed']);
                }

                $data['slug'] = $this->createCompanySlug($data['name']);
                /* to add 'https://' website url if not exists */
                if(isset($data['website_url']) && $data['website_url'] != null && $data['website_url'] != ''){
                    $httpsContains = Str::contains($data['website_url'], ['https://', 'http://']);
                    if($httpsContains == false){
                        $data['website_url'] = 'https://'.$data['website_url'];
                    }
                }
                $company_profile_id = CompanyProfile::create($data);

                if(isset($data['industry']))
                {   
                    $industries = [];
                    foreach($data['industry'] as $key => $industry){
                        $industries[$key]['company_type_id'] = $industry;
                        $industries[$key]['company_profile_id'] = $company_profile_id->id;
                    }
                    CompanyProfileCompanyType::insert($industries);
                }

                /*if($request->hasfile('multi_image_url')){
                    $files = $request->file('multi_image_url');
                    $gallery_images = [];
                    $sort_order = $request->all()['multi_image_data'];
                    //dd($sort_order);
                    foreach($files as $key => $imgfile) {
                        $originalFileName = time() . '_' .$imgfile->getClientOriginalName();
                        \Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $imgfile,$originalFileName);
                        $gallery_images[$key]['company_profile_id'] = $company_profile_id->id;
                        $gallery_images[$key]['image'] = $originalFileName;
                        $gallery_images[$key]['sort'] = $key;
                    }
                    CompanyProfileGallery::insert($gallery_images);
                }*/
                //die();
                
                if(isset($data['benefit']) && count($data['benefit']) > 0){
                    foreach($data['benefit'] as $val){
                        CompanyProfileBenefitCat::create([
                            'company_profile_id' => $company_profile_id->id,
                            'benefit_cat_id' => $val,
                        ]);
                    }
                }
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
            $user = CompanyProfile::with('company_types')->where('uuid',$request->all()['id'])->first();
            if($user)
            {   
                //get plan id
                $planId = Subscription::where(['user_id'=>$user->user_id])->first();
                $job_posts_count = JobPost::where('company_profile_id', $user['id'])->count();
                if(!empty($planId)){
                    $getPlanName = getPlanName($planId['stripe_plan'],$planId['ends_at']);
                    $total = $job_posts_count - $getPlanName['slot'];
                    if($total > 0){
                        for($i = 0;$i<$total;$i++){
                            JobPost::where(["company_profile_id"=>$user['id']])->orderBy("id","ASC")->limit(1)->delete();
                        }
                        $job_posts_count = $job_posts_count - $total;
                    }
                }else{
                  $getPlanName = ["name"=>"Free Plan","slot"=>"0"];  
                }
               
                if(isset($user) && isset($user->company_types)){
                    $collection = $user->company_types;    
                    $names = $collection->pluck("id")->toArray(); 
                } 

                $gallery_images = CompanyProfileGallery::select('id','image','sort')->where('company_profile_id',$user['id'])->orderBy('sort','ASC')->get();
                $gal_images = [];
                foreach($gallery_images as $key => $image){
                    $gallery_images[$key]['image'] = getBucketImageUrl($request->all()['id'],$image->image,'company');
                }
                $user->logo_image_src = ($user->logo_image_url) ? getBucketImageUrl($request->all()['id'],$user->logo_image_url,'company') : '';
                
                $user->featured_image_src = ($user->featured_image_url) ? getBucketImageUrl($request->all()['id'],$user->featured_image_url,'company') : '';

            }else{
                redirect('/employer/create-company');
            }
            $benefitCats = BenefitCat::pluck('name','id');
            $companyProfileBenefitTag = CompanyProfileBenefitCat::where('company_profile_id',$user->id)->pluck('benefit_cat_id');
            $industries = CompanyType::pluck('name','id');
            $data = ['user'=>$user,'industries'=>$industries,'fileUrls'=>$gallery_images,'plan_name'=>$getPlanName,'job_posts_count' => $job_posts_count,'industryTest'=>$names,'benefitCats'=>$benefitCats,'companyProfileBenefitTag' => $companyProfileBenefitTag];
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

        $requested_data = $request->except(['logo_image_src','featured_image_url','industry','multi_image_url']);
        $user = CompanyProfile::with('company_types')->where('uuid',$request->all()['id'])->first();
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
            'description' => isset($requested_data['description']) ? $requested_data['description'] : '',
            'industry' => isset($requested_data['industry']) ? $requested_data['industry'] : '',
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
            'featured_image_removed' => isset($requested_data['featured_image_removed']) ? $requested_data['featured_image_removed'] : '',
            'benefit' => isset($requested_data['benefit']) ? $requested_data['benefit'] : '',
        ];

        $messages = [
            'max' => 'The company logo must not be greater than 1 MB',
            'name.required' => 'Company name is required',
            'description.required' => 'Company description is required',
        ]; 
       
        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
            'local_employees' => 'nullable|numeric',
            'global_employees' => 'nullable|numeric',
            'logo_image_url' => 'mimes:jpeg,png,jpg,gif|max:1000|nullable'
            
        ],$messages);
        
        if ($validator->fails()){
            $industries = CompanyType::pluck('name','id');
            if(isset($user) && isset($user->company_types)){
                $collection = $user->company_types;    
                $names = $collection->pluck("id")->toArray(); 
            } 
            $data['logo_image_src'] = ($user->logo_image_url) ? getBucketImageUrl($user_uuid,$user->logo_image_url,'company') : '';
            $data['featured_image_src'] = ($user->featured_image_url) ? getBucketImageUrl($user_uuid,$user->featured_image_url,'company') : '';

            $user_data = ['user'=>$data,'industries'=>$industries,'industryTest'=>$names];
            return $this->sendCustomValidationErrorsWithData($redirect_page,$validator->errors(),$user_data);
        }else{
            try{
                //dd(count($data['benefit']));
                $profile_image = '';
                $image_name = '';
                $headerimage_name = '';
                $featured_image = '';
                if ($image = $request->file('logo_image_url')) {
                    $image_name = time() . '_' . $image->getClientOriginalName();
                    $profile_image = Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $image,$image_name);
                }

                /*if ($headerimage = $request->file('featured_image_url')) {
                     $headerimage_name = time() . '_' . $headerimage->getClientOriginalName();
                     $featured_image = Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $headerimage,$headerimage_name);
                 }*/
                
                if(isset($user) && $user->name != $data['name']){
                    $updated_slug = $this->createCompanySlug($data['name']);
                }else{
                    $updated_slug = $user->slug;
                }
                /* to add 'https://' website url if not exists */
                if(isset($data['website_url']) && $data['website_url'] != null && $data['website_url'] != ''){
                    $httpsContains = Str::contains($data['website_url'], ['https://', 'http://']);
                    if($httpsContains == false){
                        $data['website_url'] = 'https://'.$data['website_url'];
                    }
                }
                $profile_data = [
                    "name"=>$data['name'],
                    'user_id' => $data['user_id'],
                    'local_employees' => $data['local_employees'],
                    'global_employees' => $data['global_employees'],
                    'website_url' => $data['website_url'],
                    'mission' => $data['mission'],
                    'description' => $data['description'],
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
                    // 'featured_image_url' => $headerimage_name,
                    'slug' => $updated_slug,
                ];
                
              
               
                if(!$request->file('logo_image_url') && (isset($data['logo_image_removed']) && $data['logo_image_removed'] == 0))
                {
                    unset($profile_data['logo_image_url']);
                }

                if(!$request->file('featured_image_url') && (isset($data['featured_image_removed']) && $data['featured_image_removed'] == 0))
                {
                    unset($data['featured_image_url']);
                }

               

                $company = CompanyProfile::where('uuid',$requested_data['id']);
                $company->update($profile_data);
                $companyDetails = $company->first();
                if($request->input('industry'))
                {   
                    $industries = [];
                    foreach($request->input('industry') as $key => $industry){
                        $industries[$key]['company_type_id'] = $industry;
                        $industries[$key]['company_profile_id'] = $companyDetails->id;
                    }
                    CompanyProfileCompanyType::where('company_profile_id',$companyDetails->id)->delete();
                    CompanyProfileCompanyType::insert($industries);
                }
                /*if($request->hasfile('multi_image_url')){
                    $files = $request->file('multi_image_url');
                    $gallery_images = [];
                    $sort_order = $request->all()['multi_image_data'];
                    foreach($files as $key => $imgfile) {
                        $originalFileName = time() . '_' .$imgfile->getClientOriginalName();
                        \Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $imgfile,$originalFileName);
                        $gallery_images[$key]['company_profile_id'] = $companyDetails->id;
                        $gallery_images[$key]['image'] = $originalFileName;
                        $gallery_images[$key]['sort'] = $sort_order[$key]['sort'];
                    }
                    $old_images = CompanyProfileGallery::select('image')->where('company_profile_id',$companyDetails->id);
                    foreach($old_images->get() as $image)
                    {
                        \Storage::disk('s3')->delete('company/'.$user_uuid.'/'. $image);
                    }
                    $old_images->delete();
                    CompanyProfileGallery::insert($gallery_images);
                }else{
                    $files = $request->all()['multi_image_data'];
                    $gallery_images = [];
                    foreach($files as $key => $imgfile) {
                        $gallery_images[$key]['company_profile_id'] = $companyDetails->id;
                        $gallery_images[$key]['image'] = pathinfo($imgfile['image'])['basename'];
                        $gallery_images[$key]['sort'] = $key;
                    }
                    $old_images = CompanyProfileGallery::select('image')->where('company_profile_id',$companyDetails->id);
                    $old_images->delete();
                    CompanyProfileGallery::insert($gallery_images);
                }*/

                ActivityLog::addToLog(__('activitylogs.company_profile_updated'),'company updated');

                $user = CompanyProfile::with('company_types')->where('uuid',$requested_data['id'])->first();
                if($user)
                {   
                    //get plan id
                    $planId = Subscription::where(['user_id'=>$user->user_id])->first();
                    $job_posts_count = JobPost::where('company_profile_id', $user['id'])->count();
                    if(!empty($planId)){
                        $getPlanName = getPlanName($planId['stripe_plan'],$planId['ends_at']);
                        $total = $job_posts_count - $getPlanName['slot'];
                        if($total > 0){
                            for($i = 0;$i<$total;$i++){
                                JobPost::where(["company_profile_id"=>$user['id']])->orderBy("id","ASC")->limit(1)->delete();
                            }
                            $job_posts_count = $job_posts_count - $total;
                        }
                    }else{
                    $getPlanName = ["name"=>"Free Plan","slot"=>"2"];  
                    }
                
                    if(isset($user) && isset($user->company_types)){
                        $collection = $user->company_types;    
                        $names = $collection->pluck("id")->toArray(); 
                    } 
                    
                    $user->logo_image_src = ($user->logo_image_url) ? getBucketImageUrl($requested_data['id'],$user->logo_image_url,'company') : '';
                    $user->featured_image_src = ($user->featured_image_url) ? getBucketImageUrl($requested_data['id'],$user->featured_image_url,'company') : '';
                    CompanyProfileBenefitCat::where('company_profile_id',$user->id)->delete();
                    if(isset($data['benefit']) && $data['benefit'] != ''){
                        if(count($data['benefit']) > 0){
                            foreach($data['benefit'] as $val){
                                CompanyProfileBenefitCat::create([
                                    'company_profile_id' => $user->id,
                                    'benefit_cat_id' => $val,
                                ]);
                            }
                        }
                    }

                }

                $industries = CompanyType::pluck('name','id');
                $data = [
                    'success'=>['status' => $this->successStatus,'message' => __('messages.company_profile_updated'),'responseCode'=> $this->successResponse],
                    'user'=>$user,
                    'industries'=>$industries,
                    'plan_name'=>$getPlanName,
                    'job_posts_count' => $job_posts_count,
                    'industryTest'=>$names
                ];
                
                //return $this->sendResponseWithData('employer/edit-company',__('messages.company_profile_updated'),$data);
                return redirect('employer/edit-company?id=' . $user->uuid)->with(['message' => __('messages.company_profile_updated')." <a class='toster-anchor' href=/companies/".$user->slug.">View Profile</a>"]);
            //return redirect()->route('edit.company',['id'=>$requested_data['id']])->with(['message' => __('messages.company_profile_updated')]);
     
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

    public function photoGallery(Request $request){

        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        try{
            $user = CompanyProfile::with('company_types')->where('uuid',$request->all()['id'])->first();
            if($user)
            {   
                //get plan id
                $planId = Subscription::where(['user_id'=>$user->user_id])->first();
                $job_posts_count = JobPost::where('company_profile_id', $user['id'])->count();
                if(!empty($planId)){
                    $getPlanName = getPlanName($planId['stripe_plan'],$planId['ends_at']);
                    $total = $job_posts_count - $getPlanName['slot'];
                    if($total > 0){
                        for($i = 0;$i<$total;$i++){
                            JobPost::where(["company_profile_id"=>$user['id']])->orderBy("id","ASC")->limit(1)->delete();
                        }
                        $job_posts_count = $job_posts_count - $total;
                    }
                }else{
                  $getPlanName = ["name"=>"Free Plan","slot"=>"0"];  
                }

                $gallery_images = CompanyProfileGallery::select('id','image','sort')->where('company_profile_id',$user['id'])->orderBy('sort','ASC')->get();
                $gal_images = [];
                foreach($gallery_images as $key => $image){
                    $gallery_images[$key]['image'] = getBucketImageUrl($request->all()['id'],$image->image,'company');
                }
              
                $data = ['user'=>$user,'fileUrls'=>$gallery_images,'plan_name'=>$getPlanName,'job_posts_count' => $job_posts_count];
                return $this->sendResponseWithData('employer/photo-gallery','',$data);
            }else{
                redirect('/employer/create-company');
            }
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    public function updatePhotoGallery(Request $request){

        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }
            try{
                $user_uuid = $request->all()['id'];
                //dd($request->all());
                $companyDetails = CompanyProfile::where('uuid',$user_uuid)->first();
                if($request->hasfile('multi_image_url')){
                    $files = $request->file('multi_image_url');
                    $gallery_images = [];
                    //$sort_order = $request->all()['multi_image_data'];
                    $old_images = CompanyProfileGallery::select('image')->where('company_profile_id',$companyDetails->id);
                    if($old_images->count() < 5)
                    {
                        $sort_order = 0;
                        if($old_images->first()) {
                            $sort_order = CompanyProfileGallery::select('sort')->where('company_profile_id',$companyDetails->id)->orderBy('sort','DESC')->first()['sort'];
                            $sort_order++;
                        }
                        foreach($files as $key => $imgfile) {
                            $originalFileName = time() . '_' .$imgfile->getClientOriginalName();
                            \Storage::disk('s3Company')->putFileAs('company/'.$user_uuid, $imgfile,$originalFileName);
                            $gallery_images[$key]['company_profile_id'] = $companyDetails->id;
                            $gallery_images[$key]['image'] = $originalFileName;
                            if(count($files) > 1)
                            {
                                $gallery_images[$key]['sort'] = $sort_order++;
                            }else{
                                $gallery_images[$key]['sort'] = $sort_order;
                            }
                            
                        }
                        
                        foreach($old_images->get() as $image)
                        {
                            \Storage::disk('s3')->delete('company/'.$user_uuid.'/'. $image);
                        }
                        //$old_images->delete();
                        CompanyProfileGallery::insert($gallery_images);
                    } else {
                        return redirect('employer/photo-gallery?id=' . $companyDetails->uuid)->with(['message' => 'max upload 4 only.']);
                    }
                }

                ActivityLog::addToLog(__('activitylogs.company_gallery_insert'),'company gallery updated');
            
                //return $this->sendResponseWithData('employer/edit-company',__('messages.company_profile_updated'),$data);
                return redirect('employer/photo-gallery?id=' . $user_uuid)->with(['message' => __('messages.company_gallery_updated')." <a class='toster-anchor' href=/companies/".$companyDetails->slug.">View Profile</a>"]);
            //return redirect()->route('edit.company',['id'=>$requested_data['id']])->with(['message' => __('messages.company_profile_updated')]);
     
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse('login',$message);
            }
    }

    public function updatePhotoGalleryOrder(Request $request){

        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }
            try{
                $user_uuid = $request->all()['id'];
                //dd($request->all());
                $companyDetails = CompanyProfile::where('uuid',$user_uuid)->first();
        
                    $files = $request->all()['multi_image_sort'];
                    $gallery_images = [];
                    foreach($files as $key => $imgfile) {
                        $gallery_images[$key]['company_profile_id'] = $companyDetails->id;
                        $gallery_images[$key]['image'] = pathinfo($imgfile['image'])['basename'];
                        $gallery_images[$key]['sort'] = $key;
                        $old_images = CompanyProfileGallery::where('id',$imgfile['id']);
                        $old_images->update(['sort'=>$key]);
                    }
                    

                ActivityLog::addToLog(__('activitylogs.company_gallery_order_updated'),'company gallery order updated');
            
                //return $this->sendResponseWithData('employer/edit-company',__('messages.company_profile_updated'),$data);
                return redirect('employer/photo-gallery?id=' . $user_uuid);
                //return Inertia::render('employer/photo-gallery',['id' => $user_uuid]);
            //return redirect()->route('edit.company',['id'=>$requested_data['id']])->with(['message' => __('messages.company_profile_updated')]);
     
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse('login',$message);
            }
    }

    public function destroyPhotoGalleryImage(Request $request){
        try {
            $p_id = $request->all()['p_id'];
            $uuid = $request->all()['id'];
            if(isset($p_id)){
                $company_photo = CompanyProfileGallery::where('id',$p_id);
                if($company_photo->first())
                {
                    \Storage::disk('s3')->delete('company/'.$uuid.'/'. $company_photo->first()->image);
                }
                $company_photo->delete();
                ActivityLog::addToLog(__('activitylogs.company_gallery_image_removed'), 'photo deleted');
            }
            return redirect('employer/photo-gallery?id=' . $uuid);
            //return Inertia::render('employer/photo-gallery?id=' . $uuid);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
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

    public function companies(Request $request)
    {

        try {
            $company = CompanyProfile::select(
                    'company_profiles.id',
                    'company_profiles.name',
                    'company_profiles.logo_image_url',
                    'company_profiles.uuid',
                    'company_profiles.slug',
                )
                ->withCount('job_posts')
                ->with(['company_types:name'])
                ->orderBy('company_profiles.created_at', 'DESC')
                ->paginate($this->paginationLimit)->onEachSide(0); 
            //dd($company);    
             
            $data = [];
            foreach ($company as $key => $comp) {
                if (!str_starts_with($company[$key]['logo_image_url'], 'https://')) {
                    $company[$key]['logo_image_url'] = ($comp['logo_image_url']) ? getBucketImageUrl($comp['uuid'], $comp['logo_image_url'], 'company') : '';
                }
                if(isset($company) && isset($comp->company_types)){
                    $collection = $comp->company_types;    
                    $names = $collection->pluck("name")->toArray(); 
                    $company[$key]['industry_types'] = implode(' | ',$names);
                }    
            }
            $data = $company;
            return Inertia::render('companies', ['data' => $data])->withViewData(['meta' => 1,"metaTitle" => "Companies - Made in Tampa","metaDescription" => "Companies Hiring in the Tampa Bay"]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login', $message);
        }
    }

    public function showCompany(Request $request,$slug = ''){
        try{
            $company = CompanyProfile::leftjoin('locations','company_profiles.location_id','locations.id')
            ->leftjoin('users','company_profiles.user_id','=','users.id')
            ->select(
                'company_profiles.id',
                'company_profiles.name',
                'company_profiles.mission',
                'company_profiles.description',
                'company_profiles.state_abbr',
                'company_profiles.name',
                'locations.name as location',
                'company_profiles.local_employees',
                'company_profiles.global_employees',
                'company_profiles.year_founded',
                'company_profiles.website_url',
                'company_profiles.created_at',
                'company_profiles.logo_image_url',
                'company_profiles.featured_image_url',
                'company_profiles.state_abbr as state',
                'company_profiles.city',
                'company_profiles.uuid',
                'company_profiles.unclaimed',
                'company_profiles.slug',
            )->
            with(['company_types:name','articles' => function ($query) {
                $query->select('articles.id','articles.slug','articles.header_image','articles.title','articles.content','articles.publish_date','users.id as author_id','users.name as author_name');
                $query->leftjoin('users','articles.author_id','users.id');
                $query->where('is_published',1);
                $query->orderBy('articles.id','DESC');
                $query->limit(3);
            }])
            ->where('company_profiles.slug',$slug)->first();
            
            /*if(Auth::check())
            {
                if($company->user_id == Auth::id()) 
                {
                    $company->unclaimed = 0;
                }
            }*/
            if(isset($company)){
                $gal_images = [];
                $gallery_images = CompanyProfileGallery::where('company_profile_id',$company->id)->orderBy('sort','ASC')->pluck('image','id');
                foreach($gallery_images as $key => $image){
                    $gal_images[] = getBucketImageUrl($company->uuid,$image,'company');
                }
                $company['gallery'] = $gal_images;
                
            }
            if(isset($company) && isset($company->company_types)){
                $collection = $company->company_types;    
                $names = $collection->pluck("name")->toArray(); 
                $company['industry_types'] = implode(' | ',$names);
            }    
            // If we don't have a url then assume it's in the S3 bucket
            if(!str_starts_with($company['logo_image_url'], 'https://')){
                $company['logo_image_url'] = ($company['logo_image_url']) ? getBucketImageUrl($company['uuid'],$company['logo_image_url'],'company') : '';
            }

            if(!str_starts_with($company['featured_image_url'], 'https://')){
                $company['featured_image_url'] = ($company['featured_image_url']) ? getBucketImageUrl($company['uuid'],$company['featured_image_url'],'company') : '';
            }
            $job_posts_query = JobPost::select('job_posts.name','job_posts.apply_url as apply_url','job_posts.created_at','job_posts.slug as job_slug','locations.name as location','company_profiles.name as company_name','company_profiles.slug as company_slug','company_profiles.state_abbr as state','company_profiles.city')
            ->leftjoin('company_profiles','job_posts.company_profile_id','company_profiles.id')
            ->leftjoin('locations','job_posts.location_id','locations.id')
            ->where('company_profile_id',$company['id'])->orderBy('job_posts.created_at','DESC');

            $job_posts_count = $job_posts_query->count();

            $job_posts = $job_posts_query->paginate(5)->onEachSide(0);
            /* if company belong to loggedin user */
            $is_company_belong_to = 0;
            if(Auth::user() != null){
                $is_user_company = CompanyProfile::where(['user_id' => Auth::user()->id,'slug' => $slug])->first();
                if($is_user_company != null){
                    $is_company_belong_to = 1;
                }
            }
            $companyProfileBenefits = CompanyProfileBenefitCat::with('benefit_cats')->where('company_profile_id',$company->id)->get();
            $meta = [
                'meta' => 1,
                "metaTitle" => "Made in Tampa Companies - Companies",
                "metaDescription" => substr(strip_tags($company->description), 0, 128),
                "metaArticle" => 1,
                "metaArticleURL" => url('companies/'.$company->slug),
                "metaArticleTitle" => $company->name,
                "metaArticleDescription" => substr(strip_tags($company->description), 0, 128),
                "metaArticleImageURL" => ($company->logo_image_url)?$company->logo_image_url:url('/images/default-company-logo.svg')
            ];
            return Inertia::render('single-company',['data'=>$company,'articles'=>$company->articles,'job_posts_count'=>$job_posts_count,'job_posts'=>$job_posts,'is_company_belong_to' => $is_company_belong_to,'companyProfileBenefits' => $companyProfileBenefits])->withViewData($meta);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('404',$message);
        }
    }



    public function claimProfile($id = ''){   
       try{
            ActivityLog::addToLog(__('activitylogs.company_profile_updated'),'company claimed');
            $user = CompanyProfile::leftjoin('users','company_profiles.user_id','=','users.id')
            ->select('company_profiles.name as company_name','users.name','users.email','company_profiles.slug as company_slug')
            ->where('company_profiles.uuid',$id)->first(); 

            Mail::send('emails.claimCompanyProfile',['user'=>$user], function($message){
                $message->to(env('ADMIN_EMAIL'));
                $message->subject(__('messages.profile_claimed'));
            });

            $redirect_link = "/companies/".$user->company_slug;
            return redirect()->intended($redirect_link)->with(['message' => __('messages.company_claimed')]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }
}