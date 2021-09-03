<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Redirect;


class CompanyProfileController extends Controller
{
    
    public function create(){
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        try{
            $user = Auth::user();
            return Inertia::render('employer/create-company');
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
    public function store(Request $request){        
          
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        $requested_data = $request->all();
        /*echo '<pre>';
        print_r($requested_data);
        die();*/
        $user_id = Auth::id();
        $redirect_page = $request->path();
        
        //$user_profile_data =  EmployerProfile::where('user_id',$user_id)->first();  
        
        $data = [
            "name"=>$requested_data['name'],
            'user_id' => $user_id,
            'local_employees' => isset($requested_data['local_employees']) ? $requested_data['local_employees'] : '',
            'global_employees' => isset($requested_data['global_employees']) ? $requested_data['global_employees'] : '',
            'website_url' => isset($requested_data['website_url']) ? $requested_data['website_url'] : '',
            'mission' => isset($requested_data['mission']) ? $requested_data['mission'] : '',
            'industry' => isset($requested_data['industry']) ? implode(',',$requested_data['industry']) : '',
            'street_addr_1' => isset($requested_data['street_addr_1']) ? $requested_data['street_addr_1'] : '',
            'street_addr_2' => isset($requested_data['street_addr_2']) ? $requested_data['street_addr_2'] : '',
            'city' => isset($requested_data['city']) ? $requested_data['city'] : '',
            'postcode' => isset($requested_data['postcode']) ? $requested_data['postcode'] : '',
            'state_abbr' => isset($requested_data['state']) ? $requested_data['state'] : '',
            'linkedin_user' => isset($requested_data['linkedin_user']) ? $requested_data['linkedin_user'] : '',
            'facebook_user' => isset($requested_data['facebook_user']) ? $requested_data['facebook_user'] : '',
            'twitter_user' => isset($requested_data['twitter_user']) ? $requested_data['twitter_user'] : '',
            'instagram_user' => isset($requested_data['instagram_user']) ? $requested_data['instagram_user'] : '',
            'logo_image_removed' => isset($requested_data['logo_image_removed']) ? $requested_data['logo_image_removed'] : '',
        ];

        $messages = [
            'max' => 'The company logo must not be greater than 1 MB',
        ]; 

        $validator = Validator::make($data, [
            'logo_image_url' => 'nullable|mimes:jpeg,png,jpg,gif|max:1000',
        ],$messages);
        
        if ($validator->fails()){
            return $this->sendValidationErrorsWithData($redirect_page,$validator->errors(),$data);
        }else{
            try{

                //$image = $request->file('logo_image_url');
                $user_uuid = Str::uuid();

                $profile_image = '';
                $image_name = '';
                if ($image = $request->file('logo_image_url')) {
                    $image_name = time() . '_' . $image->getClientOriginalName();
                       // $profile_image = Storage::disk('s3')->putFileAs('company/'.$user_uuid, $image,$image_name);
                }

                $user_profile = CompanyProfile::where('user_id',$user_id);
                
                $profile_data = [
                    "name"=>$data['name'],
                    'user_id' => $user_id,
                    'uuid' => $user_uuid,
                    'local_employees' => $data['local_employees'],
                    'global_employees' => $data['global_employees'],
                    'website_url' => $data['website_url'],
                    'mission' => $data['mission'],
                    'industry_ids' => $data['industry'],
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
                ];


                if(!$request->file('logo_image_url') && (isset($data['logo_image_removed']) && $data['logo_image_removed'] == 0))
                {
                    unset($profile_data['logo_image_removed']);
                }else{
                    
                }

                $user = CompanyProfile::create($profile_data);
                if($user)
                {
                    if ($image = $request->file('logo_image_url')) {
                        $image_name = time() . '_' . $image->getClientOriginalName();
                        Storage::disk('s3')->putFileAs('company/'.$user->uuid, $image,$image_name);
                    }
                }
                /*$user_profile_data =  CompanyProfile::where('id',$user->id)->first();    
                $user_data = [
                        'name' => $data['name'],
                        'current_job_title' => $user_profile_data['current_job_title'],
                        'short_bio' => $user_profile_data['short_bio'],
                        'linkedin' => $user_profile_data['linkedin'],
                        'logo_image_src' => $user_profile_data['profile_image'],
                ];*/
                //ActivityLog::addToLog(__('activitylogs.profile_updated'),'profile update');
                $user = User::join('employer_profiles','users.id','=','employer_profiles.user_id')->where('users.id',Auth::id())->first();
                return Redirect::route('employer.profile')->with( ['success' => __('messages.user_profile_updated')] );

                //return $this->sendResponseWithUserData('employer/profile',__('messages.user_profile_updated'),$user);
                 
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
            return $this->sendResponseWithUserData('employer/edit-company','',$user);
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

        $requested_data = $request->all();
        $user_id = Auth::id();
        $redirect_page = $request->path();
        
        //$user_profile_data =  EmployerProfile::where('user_id',$user_id)->first();  
        
        $data = [
            "name"=>$requested_data['name'],
            'user_id' => $user_id,
            'local_employees' => isset($requested_data['local_employees']) ? $requested_data['local_employees'] : '',
            'global_employees' => isset($requested_data['global_employees']) ? $requested_data['global_employees'] : '',
            'website_url' => isset($requested_data['website_url']) ? $requested_data['website_url'] : '',
            'mission' => isset($requested_data['mission']) ? $requested_data['mission'] : '',
            'industry' => isset($requested_data['industry']) ? implode(',',$requested_data['industry']) : '',
            'street_addr_1' => isset($requested_data['street_addr_1']) ? $requested_data['street_addr_1'] : '',
            'street_addr_2' => isset($requested_data['street_addr_2']) ? $requested_data['street_addr_2'] : '',
            'city' => isset($requested_data['city']) ? $requested_data['city'] : '',
            'postcode' => isset($requested_data['postcode']) ? $requested_data['postcode'] : '',
            'state_abbr' => isset($requested_data['state']) ? $requested_data['state'] : '',
            'linkedin_user' => isset($requested_data['linkedin_user']) ? $requested_data['linkedin_user'] : '',
            'facebook_user' => isset($requested_data['facebook_user']) ? $requested_data['facebook_user'] : '',
            'twitter_user' => isset($requested_data['twitter_user']) ? $requested_data['twitter_user'] : '',
            'instagram_user' => isset($requested_data['instagram_user']) ? $requested_data['instagram_user'] : '',
            'logo_image_removed' => isset($requested_data['logo_image_removed']) ? $requested_data['logo_image_removed'] : '',
        ];

        $messages = [
            'max' => 'The company logo must not be greater than 1 MB',
        ]; 

        $validator = Validator::make($data, [
            'logo_image_url' => 'nullable|mimes:jpeg,png,jpg,gif|max:1000',
        ],$messages);
        
        if ($validator->fails()){
            return $this->sendValidationErrorsWithData($redirect_page,$validator->errors(),$data);
        }else{
            try{

                //$image = $request->file('logo_image_url');
                $user_uuid = Str::uuid();

                $profile_image = '';
                $image_name = '';
                if ($image = $request->file('logo_image_url')) {
                    $image_name = time() . '_' . $image->getClientOriginalName();
                       // $profile_image = Storage::disk('s3')->putFileAs('company/'.$user_uuid, $image,$image_name);
                }

                $user_profile = CompanyProfile::where('user_id',$user_id);
                
                $profile_data = [
                    "name"=>$data['name'],
                    'user_id' => $user_id,
                    'uuid' => $user_uuid,
                    'local_employees' => $data['local_employees'],
                    'global_employees' => $data['global_employees'],
                    'website_url' => $data['website_url'],
                    'mission' => $data['mission'],
                    'industry_ids' => $data['industry'],
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
                ];


                if(!$request->file('logo_image_url') && (isset($data['logo_image_removed']) && $data['logo_image_removed'] == 0))
                {
                    unset($profile_data['logo_image_removed']);
                }else{
                    
                }

                $user = CompanyProfile::where('id',$requested_data['id'])->update($profile_data);
                if($user)
                {
                    if ($image = $request->file('logo_image_url')) {
                        $image_name = time() . '_' . $image->getClientOriginalName();
                        Storage::disk('s3')->putFileAs('company/'.$user->uuid, $image,$image_name);
                    }
                }
                /*$user_profile_data =  CompanyProfile::where('id',$user->id)->first();    
                $user_data = [
                        'name' => $data['name'],
                        'current_job_title' => $user_profile_data['current_job_title'],
                        'short_bio' => $user_profile_data['short_bio'],
                        'linkedin' => $user_profile_data['linkedin'],
                        'logo_image_src' => $user_profile_data['profile_image'],
                ];*/
                //ActivityLog::addToLog(__('activitylogs.profile_updated'),'profile update');
                $user = User::join('employer_profiles','users.id','=','employer_profiles.user_id')->where('users.id',Auth::id())->first();
                return Redirect::route('employer.profile')->with( ['success' => __('messages.user_profile_updated')] );

                //return $this->sendResponseWithUserData('employer/profile',__('messages.user_profile_updated'),$user);
                 
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }
}
