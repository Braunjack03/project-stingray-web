<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $successResponse = 200;
    public $errorResponse = 400;
    public $notFoundResponse = 200;
    public $successStatus = 1;
    public $errorStatus = 0;
    

    public function sendErrors($error){
        $error = json_decode($error);
        if(!empty($error)){
            foreach($error as $key => $value){
                $response = ['status' => $this->errorStatus,'message' => $value[0],'data'=>[],'responseCode'=> $this->errorResponse];
                return response($response, $this->errorResponse);
                break;
            }
        }
        
    }
    
}
