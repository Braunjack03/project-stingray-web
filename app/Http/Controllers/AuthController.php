<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;

class AuthController extends Controller
{
    /*
        Function Name: Register
        Description: To register job seeker
    */
    public function register(Request $request){
      
        $validator = Validator::make($request->all()['data'], [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()){
            return $this->sendErrors($validator->errors());
        }else{
            try{
                try{
                    $data = $request->all()['data'];
                    $check_exists =  User::where('email', '=', $data['email'])->count();
                }catch (ModelNotFoundException $e){
                    $response = ['status' => $this->errorStatus,'message' => $e->getMessage(),'responseCode'=> $this->errorResponse];
                    return response($response, $this->errorResponse);
                }

                if ($check_exists > 0) {
                    $response = ['status' => $this->errorStatus,'message' => __('messages.user_already_registered'),'responseCode'=> $this->errorResponse];
                    return response($response, $this->errorResponse);
                }else{
                    try{
                        if($data['user_type'] == 'job_seeker'){
                            $user = User::create([
                                'email' => $data['email'],
                                'password' => bcrypt($data['password']),
                            ]);
                        }
                    }catch (ModelNotFoundException $e){
                        $response = ['status' => $this->errorStatus,'message' => $e->getMessage(),'responseCode'=> $this->errorResponse];
                        return response($response, $this->errorResponse);
                    }
                    $data = [
                        'email' => $data['email'],
                    ];
                    $response = ['status' => $this->successStatus,'message' => __('messages.user_registeration'),'data'=>$data,'responseCode'=> $this->successResponse];
                    return response($response, $this->successResponse); 
                }        
            }catch (\Exception $e) {
                $response = ['status' => $this->errorStatus,'message' => $e->getMessage(),'responseCode'=> $this->errorResponse];
                return response($response, $this->errorResponse);
            }
        } 
    }
}
