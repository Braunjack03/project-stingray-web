<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\JobPost;
use App\Models\JobCat;
use App\Models\Location;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use App\Models\ActivityLog;
use Redirect;

class JobPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get Job Posts
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
            $job_posts = JobPost::where('user_id',$user->id)->get()->toArray();
            $response = ['status' => $this->successStatus,'message' => '','responseCode'=> $this->successResponse];
            $respones_array = [
                'success' => $response,
                //'user' => $data,
                'job_posts' => json_decode(json_encode($job_posts), true),
            ];
            
            return $this->sendResponseWithData('employer/job_posts','',$respones_array);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    /**
     * Get Profile
     *
     * @return \Illuminate\View\View
     */

    public function create(){
        
        //return Inertia::render('employer/job_posts');

        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        try{
            $user = Auth::user();
            $job_categories = JobCat::get();
            $locations = Location::get();
            return Inertia::render('employer/create-job',['job_categories'=>$job_categories,'locations'=>$locations]);

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
        $user_id = Auth::id();
        $job_uuid = Str::uuid();
        $request->request->add(['user_id' => $user_id,'uuid'=>$job_uuid]);

        $data = $request->all();
        
        if(!isset($data['remotetype_id']))
        {
            $data['remotetype_id'] = 3;
        }
        $redirect_page = 'employer/create-job';
        $messages = [
            'name.required' => 'Job name is required',
        ]; 
      
        $validator = Validator::make($data, [
            'name' => 'required',
            'location_id' => 'required',
            'job_cat_id' => 'required',
            'apply_url' => 'required',
            'content' => 'required',
        ],$messages);
        
        if ($validator->fails()){
            $job_categories = JobCat::get();
            $locations = Location::get();
            $data = ['user'=>$data,'job_categories'=>$job_categories,'locations'=>$locations];
            return $this->sendJobValidationErrorsWithData($redirect_page,$validator->errors(),$data);
        }else{
            try{
                
                JobPost::create($data);
               
                ActivityLog::addToLog(__('activitylogs.company_profile_created'),'company created');
                return Redirect::route('employer.jobs')->with( ['message' => __('messages.company_profile_created')] );
                 
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

     /**
     * Edit Job
     *
     * @return \Illuminate\View\View
     */

    public function edit(Request $request){
        
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        try{
            $job_data = JobPost::where('uuid',$request->all()['id'])->first();
            $job_data->remotetype_id = ($job_data->remotetype_id == 1) ? true : false;
            $job_categories = JobCat::get();
            $locations = Location::get();
            return Inertia::render('employer/edit-job',['user'=>$job_data,'job_categories'=>$job_categories,'locations'=>$locations]);

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
    public function update(Request $request){        
          
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }
        //$user_id = Auth::id();
        $job_uuid = $request->all()['id'];

        $data = $request->only(['name', 'content', 'apply_url', 'location_id', 'job_cat_id','remotetype_id']);

        //$data = $request->all();
        //echo '<pre>';
        //print_r($data);
        //die();
        if(isset($data['remotetype_id']) && $data['remotetype_id'] == 0)
        {
            $data['remotetype_id'] = 3;
        }
        $redirect_page = 'employer/edit-job';
        $messages = [
            'name.required' => 'Job name is required',
        ]; 
      
        $validator = Validator::make($data, [
            'name' => 'required',
            'location_id' => 'required',
            'job_cat_id' => 'required',
            'apply_url' => 'required',
            'content' => 'required',
        ],$messages);
        
        if ($validator->fails()){
            $job_categories = JobCat::get();
            $locations = Location::get();
            $data = ['user'=>$data,'job_categories'=>$job_categories,'locations'=>$locations];
            return $this->sendJobValidationErrorsWithData($redirect_page,$validator->errors(),$data);
        }else{
            try{
                $user = JobPost::where('id',$job_uuid)->update($data);
                ActivityLog::addToLog(__('activitylogs.company_profile_created'),'company created');
                return Redirect::route('employer.jobs')->with( ['message' => __('messages.company_profile_created')] );
                 
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

    public function destroy(Request $request)
    {
        $id = $request->all()['id'];
        JobPost::where('uuid',$id)->delete();
        return Redirect::route('employer.jobs')->with( ['message' => __('messages.job_delete')] );

    }
}
