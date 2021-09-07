<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobSeekerProfile;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;
use Inertia\Inertia;

class JobSeekerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','jobseeker']);
    }

    /**
     * Profile
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
            $user_profile = JobSeekerProfile::where('user_id',$user->id)->first();
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
                    'current_resume_src' => $user_profile->current_resume,
                    'current_resume_name' => $this->getNameFromUrl($user_profile->current_resume),
                ];
            }else{
                $data = [
                    'name' => $user->name,
                ];
            }
            ActivityLog::addToLog(__('activitylogs.profile_fetched'),'profile fetch');
            $data = json_decode(json_encode($data), FALSE);
            return $this->sendResponseWithUserData('profile','',$data);

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
    public function updateProfile(Request $request){        
          
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        $requested_data = $request->all();

        $user_id = Auth::id();
        $redirect_page = $request->path();
        $user_profile_data =  JobSeekerProfile::where('user_id',$user_id)->first();  
        
        $data = [
            "name"=> isset($requested_data['name']) ? $requested_data['name'] : '',
            'current_job_title' => isset($requested_data['current_job_title']) ? $requested_data['current_job_title'] : '',
            'short_bio' => isset($requested_data['short_bio']) ? $requested_data['short_bio'] : '',
            'linkedin' => isset($requested_data['linkedin']) ? $requested_data['linkedin'] : '',
            'github' => isset($requested_data['github']) ? $requested_data['github'] : '',
            'twitter' => isset($requested_data['twitter']) ? $requested_data['twitter'] : '',
            'profile_image' => isset($requested_data['profile_image']) ? $requested_data['profile_image'] : '',
            'current_resume' => isset($requested_data['current_resume']) ? $requested_data['current_resume'] : '',
            'profile_image_src' => isset($user_profile_data->profile_image) ? $user_profile_data->profile_image : '',
            'current_resume_src' => isset($user_profile_data->current_resume) ? $user_profile_data->current_resume : '',
            'current_resume_name' => isset($user_profile_data->current_resume) ? $this->getNameFromUrl($user_profile_data->current_resume) : '',
            'profile_image_removed' => isset($requested_data['profile_image_removed']) ? $requested_data['profile_image_removed'] : '',
            'current_resume_removed' => isset($requested_data['current_resume_removed']) ? $requested_data['current_resume_removed'] : '',
        ];

        $messages = [
            'max' => 'The profile image must not be greater than 1 MB',
        ]; 

        $validator = Validator::make($data, [
            'name' => 'required',
            'current_job_title' => 'required',
            'profile_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:1000',
            'current_resume' => 'nullable|mimes:pdf,doc,docx,txt',
        ],$messages);
        
        if ($validator->fails()){
            //$data = ['user'=>$data];
            //return $this->sendCustomProfileValidationErrorsWithData($redirect_page,$validator->errors(),$data);

            return $this->sendValidationErrorsWithData($redirect_page,$validator->errors(),$data);
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
                        $profile_image = Storage::disk('s3')->putFileAs($user_uuid, $image,$image_name);
                    }
                    
                    if ($request->file('current_resume') != '') {
                        $current_resume = $request->file('current_resume');
                        $cv_name = time() . '_' . $current_resume->getClientOriginalName();
                        $current_resume = Storage::disk('s3')->putFileAs($user_uuid, $current_resume,$cv_name);

                    }

                    $user_profile = JobSeekerProfile::where('user_id',$user_id);
                    
                    $profile_data = [
                        'user_id' => $user_id,
                        'current_job_title' => $data['current_job_title'],
                        'short_bio' => $data['short_bio'],
                        'linkedin' => $data['linkedin'],
                        'github' => $data['github'],
                        'twitter' => $data['twitter'],
                        'profile_image' => $this->getNameFromUrl($profile_image),
                        'current_resume' => $this->getNameFromUrl($current_resume),
                    ];


                    if(!$request->file('profile_image') && (isset($data['profile_image_removed']) && $data['profile_image_removed'] == 0))
                    {
                        unset($profile_data['profile_image']);
                    }

                    if (!$request->file('current_resume') && (isset($data['current_resume_removed']) && $data['current_resume_removed'] == 0)) {
                        unset($profile_data['current_resume']);
                    }   

                    if($user_profile->count() == 1)
                    {
                        JobSeekerProfile::where('user_id',$user_id)->update($profile_data);
                    }else{ 
                        JobSeekerProfile::create($profile_data);
                    } 
                }
                
                $user_profile_data =  JobSeekerProfile::where('user_id',$user_id)->first();
                
                 
                $user_data = [
                        'name' => $data['name'],
                        'current_job_title' => $user_profile_data['current_job_title'],
                        'short_bio' => $user_profile_data['short_bio'],
                        'linkedin' => $user_profile_data['linkedin'],
                        'github' => $user_profile_data['github'],
                        'twitter' => $user_profile_data['twitter'],
                        'profile_image_src' => $user_profile_data['profile_image'],
                        'current_resume_src' => $user_profile_data['current_resume'],
                        'current_resume_name' => $this->getNameFromUrl($user_profile_data['current_resume']),
                ];
                ActivityLog::addToLog(__('activitylogs.profile_updated'),'profile update');
                return $this->sendResponseWithUserData($redirect_page,__('messages.user_profile_updated'),$user_data);
                 
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

    public function getNameFromUrl($cv){
        $cv_name = pathinfo($cv);
        return $cv_name['basename'];
    }
}
