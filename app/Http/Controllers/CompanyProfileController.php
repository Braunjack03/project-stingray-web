<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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
        print_r($data);
        die();*/
        $user_id = Auth::id();
        $redirect_page = $request->path();
        
        //$user_profile_data =  EmployerProfile::where('user_id',$user_id)->first();  
        
        $data = [
            "name"=>$requested_data['name'],
            'local_employees' => isset($requested_data['local_employees']) ? $requested_data['local_employees'] : '',
            'global_employees' => isset($requested_data['global_employees']) ? $requested_data['global_employees'] : '',
            'website_url' => isset($requested_data['website_url']) ? $requested_data['website_url'] : '',
            'mission' => isset($requested_data['mission']) ? $requested_data['mission'] : '',
            //'industry' => isset($requested_data['industry']) ? $requested_data['industry'] : '',
            'street_addr_1' => isset($requested_data['street_addr_1']) ? $requested_data['street_addr_1'] : '',
            'street_addr_2' => isset($requested_data['street_addr_2']) ? $requested_data['street_addr_2'] : '',
            'city' => isset($requested_data['city']) ? $requested_data['city'] : '',
            'postcode' => isset($requested_data['postcode']) ? $requested_data['postcode'] : '',
            'state_abbr' => isset($requested_data['state']) ? $requested_data['state'] : '',
            'linkedin' => isset($requested_data['linkedin']) ? $requested_data['linkedin'] : '',
            'github' => isset($requested_data['github']) ? $requested_data['github'] : '',
            'twitter' => isset($requested_data['twitter']) ? $requested_data['twitter'] : '',
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
                $user_uuid = Auth::user()->uuid;

                $profile_image = '';
                if ($image = $request->file('logo_image_url')) {
                    $image_name = time() . '_' . $image->getClientOriginalName();
                        $profile_image = Storage::disk('s3')->putFileAs('company/'.$user_uuid, $image,$image_name);
                }

                $user_profile = CompanyProfile::where('user_id',$user_id);
                
                $profile_data = [
                    "name"=>$data['name'],
                    'local_employees' => $data['local_employees'],
                    'global_employees' => $data['global_employees'],
                    'website_url' => $data['website_url'],
                    'mission' => $data['mission'],
                    //'industry' => isset($requested_data['industry']) ? $requested_data['industry'] : '',
                    'street_addr_1' => $data['street_addr_1'],
                    'city' => $data['city'],
                    'postcode' => $data['postcode'],
                    'state_abbr' => $data['state_abbr'],
                    'linkedin_user' => $data['linkedin'],
                    'facebook_user' => $data['github'],
                    'twitter_user' => $data['twitter'],
                    'logo_image_url' => $this->getNameFromUrl($profile_image),
                ];


                if(!$request->file('logo_image_url') && (isset($data['logo_image_removed']) && $data['logo_image_removed'] == 0))
                {
                    unset($profile_data['logo_image_removed']);
                }

                $user = CompanyProfile::create($profile_data);

                /*$user_profile_data =  CompanyProfile::where('id',$user->id)->first();    
                $user_data = [
                        'name' => $data['name'],
                        'current_job_title' => $user_profile_data['current_job_title'],
                        'short_bio' => $user_profile_data['short_bio'],
                        'linkedin' => $user_profile_data['linkedin'],
                        'logo_image_src' => $user_profile_data['profile_image'],
                ];*/
                //ActivityLog::addToLog(__('activitylogs.profile_updated'),'profile update');
                $user = Auth::user();
                return $this->sendResponseWithUserData('employer/profile',__('messages.user_profile_updated'),$user);
                 
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }
}
