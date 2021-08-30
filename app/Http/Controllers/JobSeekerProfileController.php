<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobSeekerProfile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;
use Inertia\Inertia;

class JobSeekerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

            $data = json_decode(json_encode($data), FALSE);
            return Inertia::render('profile', [
                'user' => $data,
            ]);
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
        //echo '<pre>';
            //$user_id = Auth::id();
            //echo $user_id;
            //print_r($requested_data);die();

        $user_id = Auth::id();
        $redirect_page = $request->path();
        $user_profile_data =  JobSeekerProfile::where('user_id',$user_id)->first();  
        
        $data = [
                "name"=>$requested_data['name'],
                'current_job_title' => isset($requested_data['current_job_title']) ? $requested_data['current_job_title'] : '',
                'short_bio' => isset($requested_data['short_bio']) ? $requested_data['short_bio'] : '',
                'linkedin' => isset($requested_data['linkedin']) ? $requested_data['linkedin'] : '',
                'github' => isset($requested_data['github']) ? $requested_data['github'] : '',
                'twitter' => isset($requested_data['twitter']) ? $requested_data['twitter'] : '',
                'profile_image' => isset($requested_data['profile_image']) ? $requested_data['profile_image'] : '',
                'current_resume' => isset($requested_data['current_resume']) ? $requested_data['current_resume'] : '',
                'profile_image_src' => $user_profile_data->profile_image,
                'current_resume_src' => $user_profile_data->current_resume,
                'current_resume_name' => $this->getNameFromUrl($user_profile_data->current_resume),
            ];
         
        $validator = Validator::make($data, [
            'profile_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:1000',
            'current_resume' => 'nullable|mimes:pdf,doc,txt',
        ]);
        
        if ($validator->fails()){
            return $this->sendValidationErrorsWithData($redirect_page,$validator->errors(),$data);
        }else{
            try{

                    $user = User::where('id',$user_id)->update([
                        'name' => $data['name'],
                    ]);

                    if($user){
                           
                        $image = $request->file('profile_image');
                        
                        $user_uuid = Auth::user()->uuid;
                        //$path = Storage::disk('s3')->put($user_uuid, $image, 'public');
                        //$success = Storage::disk('s3')->putFile($user_uuid, $image);

                        $profileImage = '';
                        $current_resume = '';
                        $destinationPath = 'uploads/public-candidate-assets/';
                        if ($image = $request->file('profile_image')) {
                            $profileImage = date('YmdHis') . "." . $image->getClientOriginalName();
                            $image->move($destinationPath, $profileImage);
                        }
                       
                        if ($request->file('current_resume') != '') {
                            $cv = $request->file('current_resume');
                            $current_resume = date('YmdHis') . "-" . $cv->getClientOriginalName();
                            $cv->move($destinationPath, $current_resume);
                        }
                        
                        //return Storage::disk('s3')->response($user_uuid.'/'. $image->fileName);

                        $user_profile = JobSeekerProfile::where('user_id',$user_id);
                      
                        $profile_data = [
                            'user_id' => $user_id,
                            'current_job_title' => $data['current_job_title'],
                            'short_bio' => $data['short_bio'],
                            'linkedin' => $data['linkedin'],
                            'github' => $data['github'],
                            'twitter' => $data['twitter'],
                            'profile_image' => $profileImage,
                            'current_resume' => $current_resume,
                        ];

                        if(!$request->file('profile_image'))
                        {
                            unset($profile_data['profile_image']);
                        }

                        if (!$request->file('current_resume')) {
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
                $data = [
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
                
                $response = ['status' => $this->successStatus,'message' => __('messages.user_profile_updated'),'user'=>$data,'responseCode'=> $this->successResponse];
                return inertia($redirect_page, [
                    'success' => $response,
                    'user' => $data,
                ]);
                //return $this->sendSuccessResponse($redirect_page,__('messages.user_registeration'),$data);
                 
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
