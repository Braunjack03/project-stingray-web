<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\JobPost;
use App\Models\JobCat;
use App\Models\Location;
use Auth;

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
}
