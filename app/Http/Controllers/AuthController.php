<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Hash;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Mail; 



class AuthController extends Controller
{
    /*
        Function Name: Register
        Description: To register job seeker
    */
    public function register(Request $request){
        
        $data = $request->all();
        $credentials = ["email"=>$data['email'],'password'=>$data['password']];
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()){
            return $this->sendErrors('register',$validator->errors());
        }else{
            try{
                try{
                    $data = $request->all();
                    $check_exists =  User::where('email', '=', $data['email'])->count();
                }catch (ModelNotFoundException $e){
                    $response = ['status' => $this->errorStatus,'message' => $e->getMessage(),'responseCode'=> $this->errorResponse];
                    return $this->sendErrors('register',$response);
                }

                if ($check_exists > 0) {
                    $response = ['status' => $this->errorStatus,'message' => __('messages.user_already_registered'),'responseCode'=> $this->errorResponse];
                    return inertia('register', [
                        'errors' => $response,
                    ]);
                }else{
                    try{
                            $user = User::create([
                                'email' => $data['email'],
                                'role' => $data['user_type'],
                                'password' => Hash::make($data['password']),
                                'ip_address' => $request->ip(),
                            ]);
                            
                            $token = Str::random(64);
  
                            UserVerify::create([
                                  'user_id' => $user->id, 
                                  'token' => $token
                                ]);
                      
                            Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($user){
                                  $message->to($user->email);
                                  $message->subject('Email Verification Mail');
                              });

                            return Redirect::route('thankyou');
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
        $data = $request->all();
        $credentials = ["email"=>$data['email'],'password'=>$data['password']];
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ])->validate();
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            ActivityLog::addToLog('User LoggedIn Successfully!');
            /*return Inertia::render('dashboard', [
                'user' => [
                    'email' => $credentials['email'],
                    'name' => 'Tech',
                ],
            ]);*/
            
            return redirect()->intended('/dashboard');
        }
        ActivityLog::addToLog('User LoggedIn Unsuccessful!');
        return back()->withErrors([
            'message' => 'Either your password or email is incorrect',
        ]);
    }

    public function thankyou()
    {
        return Inertia::render('thankyou');
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
  
        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
              
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
        
        return inertia('login', [
            'errors' => ['message' => $message],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/login');
    }
}
