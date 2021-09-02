<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $successResponse = 200;
    public $errorResponse = 400;
    public $notFoundResponse = 200;
    public $successStatus = 1;
    public $errorStatus = 0;
    public $employerRole = 1;
    public $jobSeekerRole = 2;

    public function sendValidationErrors($route,$error){
        $error = json_decode($error);
        if(!empty($error)){
            foreach($error as $key => $value){
                $response = ['status' => $this->errorStatus,'message' => $value[0],'data'=>[],'responseCode'=> $this->errorResponse];
                return inertia($route, [
                    'errors' => $response,
                ]);
                //return response()->json($response, $this->errorResponse);
                break;
            }
        }    
    }

    public function sendSuccessResponse($route,$message,$data = []){
        $response = ['status' => $this->successStatus,'message' => $message,'data'=>$data,'responseCode'=> $this->successResponse];
        return inertia($route, [
            'success' => $response,
        ]);
    }

    public function sendErrorResponse($route,$message){
        $response = ['status' => $this->errorStatus,'message' => $message,'responseCode'=> $this->errorResponse];
        return inertia($route, [
            'errors' => $response,
        ]);
    }   

    public function sendValidationErrorsWithData($route,$error,$data){
        $error = json_decode($error);
        if(!empty($error)){
            foreach($error as $key => $value){
                $response = ['status' => $this->errorStatus,'message' => implode("\n",$value),'responseCode'=> $this->errorResponse];
                return inertia($route, [
                    'errors' => $response,
                    'user' => $data,
                ]);
                //return response()->json($response, $this->errorResponse);
                break;
            }
        }    
    }

    public function sendResponseWithUserData($route,$message,$data = []){

        $response = ['status' => $this->successStatus,'message' => $message,'user'=>$data,'responseCode'=> $this->successResponse];
        return inertia($route, [
            'success' => $response,
            'user' => $data,
        ]);
    }

    public function getRoleName($role_id)
    {
        if($role_id == 1)
        {
            $roleName = 'Employer';
        }else{
            $roleName = 'Job Seeker';
        }
        return $roleName;
    }

    public function getNameFromUrl($cv){
        $cv_name = pathinfo($cv);
        return $cv_name['basename'];
    }
}
