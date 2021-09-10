<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\JobPost;
use App\Models\JobCat;
use App\Models\Location;
use App\Models\CompanyProfile;
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

    public function index(Request $request){

        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        try{
            $user = Auth::user();

            $job_posts = JobPost::where('user_id',$user->id)->orderBy('id','DESC')->get()->toArray();
            $job_post_model = new JobPost();
            foreach($job_posts as $key => $job)
            {
                $job_posts[$key]['location_id'] = $job_post_model->getJobLocation($job['remotetype_id']);
            }
            $companies = CompanyProfile::where('uuid',$request->all()['c_id']);
            $response = ['status' => $this->successStatus,'message' => '','responseCode'=> $this->successResponse];
            $respones_array = [
                'success' => $response,
                'companies_count' => $companies->count(),
                'company_details' => $companies->first(),
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

    public function create(Request $request){

        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }
        try{
            $user = Auth::user();
            $job_categories = JobCat::get();
            $locations = Location::get();
           
            $uuid = $request->all()['c_id'];
            return Inertia::render('employer/create-job',['job_categories'=>$job_categories,'locations'=>$locations,'company_uuid'=>$uuid]);

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
       
        $company_id = $data['c_id'];
        $company_profile = 0;
        $company_profile = CompanyProfile::where('uuid',$company_id)->first();
        if($company_profile){
            $data['company_profile_id'] = $company_profile['id'];
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
               
                unset($data['c_id']);
                JobPost::create($data);
               
                ActivityLog::addToLog(__('activitylogs.job_created'),'job created');
                return redirect('employer/jobs?c_id='.$company_id)->with( ['message' => __('messages.job_created')] );
                 
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
        $job_uuid = $request->all()['id'];

        $data = $request->only(['name', 'content', 'apply_url', 'location_id', 'job_cat_id','remotetype_id']);
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
                $job = JobPost::where('id',$job_uuid);
                $job->update($data);
                $company_profile_id = CompanyProfile::where('id',$job->first()['company_profile_id'])->first()['uuid'];
                ActivityLog::addToLog(__('activitylogs.job_updated'),'job updated');
                return redirect('employer/jobs?c_id='.$company_profile_id)->with( ['message' => __('messages.job_updated')] );
                 
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

    public function destroy(Request $request)
    {
        $id = $request->all()['id'];
        $job_data = JobPost::where('uuid',$id);

        $company_profile_id = CompanyProfile::where('id',$job_data->first()['company_profile_id'])->first()['uuid'];
       
        $job_data->delete();
        ActivityLog::addToLog(__('activitylogs.job_deleted'),'job deleted');
        return redirect('employer/jobs?c_id='.$company_profile_id)->with( ['message' => __('messages.job_delete')] );

    }
}
