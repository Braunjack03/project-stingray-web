<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployerProfile;
use App\Models\CompanyProfile;
use App\Models\ActivityLog;
use App\Models\JobPost;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;
use Inertia\Inertia;

class EmployerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get Profile
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

            $user_profile = EmployerProfile::where('user_id',$user->id)->first();
            //get plan id
            $planId = Subscription::where(['user_id'=>$user->id])->first();
            $company_profiles = CompanyProfile::where('user_id',$user->id)->get()->toArray();
            $job_post_counts = 0;
            if($company_profiles){
                $job_post_counts = JobPost::where('company_profile_id', $company_profiles[0]['id'])->count();
            }
           
            if(!empty($planId)){
                $getPlanName = getPlanName($planId['stripe_plan'],$planId['ends_at']);
                $total = $job_post_counts - $getPlanName['slot'];
                if($total > 0){
                    for($i = 0;$i<$total;$i++){
                        JobPost::where(["company_profile_id"=>$company_profiles[0]['id']])->orderBy("id","ASC")->limit(1)->delete();
                    }
                    $job_post_counts = $job_post_counts - $total;
                }
            }else{
              $getPlanName = ["name"=>"Free Plan","slot"=>"2"];  
            }
            if($user_profile)
            {
                $data = [
                    'name' => $user->name,
                    'current_job_title' => $user_profile->current_job_title,
                    'short_bio' => $user_profile->short_bio,
                    'linkedin' => $user_profile->linkedin,
                    'github' => $user_profile->github,
                    'twitter' => $user_profile->twitter,
                    'profile_image_src' => $user_profile->profile_image,
                    'company_profile_count' => count($company_profiles),
                ];
            }else{
                $data = [
                    'name' => $user->name,
                    'company_profile_count' => count($company_profiles),
                ];
            }
            ActivityLog::addToLog(__('activitylogs.profile_fetched'),'profile fetch');
            $data = json_decode(json_encode($data), FALSE);
            $response = ['status' => $this->successStatus,'message' => '','responseCode'=> $this->successResponse];
            $respones_array = [
                'success' => $response,
                'user' => $data,
                'plan_name' => $getPlanName,
                'job_posts_count' => $job_post_counts,
                'companies' => json_decode(json_encode($company_profiles), true),
            ];
            
            return $this->sendResponseWithData('employer/profile','',$respones_array);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    /**
     * To update employer profile
     *
     * @return \Illuminate\View\View
     */
    public function updateProfile(Request $request){        
          
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        $requested_data = $request->all();

        $user_id = Auth::id();
        $redirect_page = $request->path();
        
        $user_profile_data =  EmployerProfile::where('user_id',$user_id)->first();  
        $company_profiles = CompanyProfile::where('user_id',$user_id)->get()->toArray();

        $data = [
            "name"=> isset($requested_data['name']) ? $requested_data['name'] : '',
            'current_job_title' => isset($requested_data['current_job_title']) ? $requested_data['current_job_title'] : '',
            'short_bio' => isset($requested_data['short_bio']) ? $requested_data['short_bio'] : '',
            'linkedin' => isset($requested_data['linkedin']) ? $requested_data['linkedin'] : '',
            'profile_image' => isset($requested_data['profile_image']) ? $requested_data['profile_image'] : '',
            'profile_image_src' => isset($user_profile_data->profile_image) ? $user_profile_data->profile_image : '',
            'profile_image_removed' => isset($requested_data['profile_image_removed']) ? $requested_data['profile_image_removed'] : '',
            'company_profile_count' => count($company_profiles),    
        ];

        $messages = [
            'max' => 'The profile image must not be greater than 1 MB',
        ]; 

        $validator = Validator::make($data, [
            'name' => 'required',
            'current_job_title' => 'required',
            'profile_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:1000',
        ],$messages);
        
        if ($validator->fails()){
            $data = ['user'=>$data,'companies'=>$company_profiles];
            return $this->sendCustomProfileValidationErrorsWithData($redirect_page,$validator->errors(),$data);
        }else{
            try{

                $user = User::where('id',$user_id)->update([
                    'name' => $data['name'],
                ]);

                if($user){
                    $image = $request->file('profile_image');
                    $user_uuid = Auth::user()->uuid;

                    $profile_image = '';
                    $current_resume = '';
                    if ($image = $request->file('profile_image')) {
                        $image_name = time() . '_' . $image->getClientOriginalName();
                            $profile_image = Storage::disk('s3Company')->putFileAs('employer/'.$user_uuid, $image,$image_name);
                    }

                    $user_profile = EmployerProfile::where('user_id',$user_id);
                    
                    $profile_data = [
                        'user_id' => $user_id,
                        'current_job_title' => $data['current_job_title'],
                        'short_bio' => $data['short_bio'],
                        'linkedin' => $data['linkedin'],
                        'profile_image' => $this->getNameFromUrl($profile_image),
                    ];

                    if(!$request->file('profile_image') && (isset($data['profile_image_removed']) && $data['profile_image_removed'] == 0))
                    {
                        unset($profile_data['profile_image']);
                    }

                    if($user_profile->count() == 1)
                    {
                        EmployerProfile::where('user_id',$user_id)->update($profile_data);
                    }else{
                        EmployerProfile::create($profile_data);
                    } 
                }
                
                $user_profile_data =  EmployerProfile::where('user_id',$user_id)->first(); 
                $company_profiles = CompanyProfile::where('user_id',$user_id)->get()->toArray();   
                $user_data = [
                        'name' => $data['name'],
                        'current_job_title' => $user_profile_data['current_job_title'],
                        'short_bio' => $user_profile_data['short_bio'],
                        'linkedin' => $user_profile_data['linkedin'],
                        'profile_image_src' => $user_profile_data['profile_image'],
                        'company_profile_count' => count($company_profiles),
                ];
                ActivityLog::addToLog(__('activitylogs.employer_profile_updated'),'employer profile update');
                $response = ['status' => $this->successStatus,'message' => __('messages.user_profile_updated'),'responseCode'=> $this->successResponse];
                $respones_array = [
                    'success' => $response,
                    'user' => $user_data,
                    'companies' => json_decode(json_encode($company_profiles), true),
                ];
                return $this->sendResponseWithData($redirect_page,__('messages.user_profile_updated'),$respones_array);                 
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

    
}
