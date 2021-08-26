<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobSeekerProfile;
use Illuminate\Support\Facades\Validator;
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
                ];
            }else{
                $data = [
                    'name' => $user->name,
                ];
            }
            return Inertia::render('profile', [
                'user' => [
                    $data
                ],
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
        echo '<pre>';
            //$user_id = Auth::id();
            //echo $user_id;
            print_r($requested_data);die();
        $redirect_page = $request->path();
        $data = [
                "name"=>$requested_data['name'],
                'current_job_title' => ($requested_data['current_job_title']) ? $requested_data['current_job_title'] : '',
                'short_bio' => ($requested_data['short_bio']) ? $requested_data['short_bio'] : '',
                'linkedin' => ($requested_data['linkedin']) ? $requested_data['linkedin'] : '',
                'github' => ($requested_data['github']) ? $requested_data['github'] : '',
                'twitter' => ($requested_data['twitter']) ? $requested_data['twitter'] : '',
            ];
        $validator = Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()){
            return $this->sendValidationErrors($redirect_page,$validator->errors());
        }else{
            try{

                    $user_id = Auth::id();
                    $user = User::where('id',$user_id)->update([
                        'name' => $data['name'],
                    ]);

                    if($user){
                        $user_profile = JobSeekerProfile::where('user_id',$user_id);
                        if($user_profile->count() == 1)
                        {
                            JobSeekerProfile::where('user_id',$user_id)->update([
                                'user_id' => $user_id,
                                'current_job_title' => $data['current_job_title'],
                                'short_bio' => $data['short_bio'],
                                'linkedin' => $data['linkedin'],
                                'github' => $data['github'],
                                'twitter' => $data['twitter'],
                            ]);
                          
                        }else{
                            JobSeekerProfile::create([
                                'user_id' => $user_id,
                                'current_job_title' => $data['current_job_title'],
                                'short_bio' => $data['short_bio'],
                                'linkedin' => $data['linkedin'],
                                'github' => $data['github'],
                                'twitter' => $data['twitter'],
                            ]);
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

}
