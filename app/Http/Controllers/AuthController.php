<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Hash;
use Auth;

class AuthController extends Controller
{
    /*
        Function Name: Register
        Description: To register job seeker
    */
    public function register(Request $request){
        $data = $request->all()['data'];
        $credentials = ["email"=>$data['email'],'password'=>$data['password']];
        $validator = Validator::make($credentials, [
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
                    return Inertia::render('register',$response);

                    return inertia('register', [
                        'data' => $response,
                    ]);
                    //return response($response, $this->errorResponse);
                }else{
                    try{
                            $user = User::create([
                                'email' => $data['email'],
                                'role' => $data['user_type'],
                                'password' => bcrypt($data['password']),
                                'ip_address' => $request->ip(),
                            ]);
                            
                            return Redirect::route('thankyou');
                       // }
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

    public function login(Request $request)
    {
        $data = $request->all()['data'];
        $credentials = ["email"=>$data['email'],'password'=>$data['password']];
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ])->validate();
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'Either your password or email is incorrect',
        ]);
    }

    public function thankyou()
    {
        return Inertia::render('thankyou');
    }
}
