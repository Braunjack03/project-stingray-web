<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
use Carbon\Carbon;


class AuthController extends Controller
{
    /**
     * Login Form
     *
     * @return \Illuminate\View\View
     */

    public function showLoginForm()
    {
        return Inertia::render('login'); 
    }

     /**
     * Login for job seeker
     *
     * @return Dashboard
     */

    public function login(Request $request)
    {
        $data = $request->all();
        $redirect_page = $request->path();
        $credentials = ["email"=>$data['email'],'password'=>$data['password']];

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()){
            return $this->sendValidationErrors($redirect_page,$validator->errors());
        }else{
            try{
                    if(Auth::attempt($credentials)) {

                        if(Auth::user()->is_email_verified != 1){
                            Auth::logout();
                            return $this->sendErrorResponse($redirect_page,__('messages.not_verified'));
                        }
                        $request->session()->regenerate();

                        ActivityLog::addToLog(__('activitylogs.loggedin_successfull'));
                        
                        return redirect()->intended('/dashboard');
                    }

                    ActivityLog::addToLog(__('activitylogs.loggedin_unsuccessfull'));

                    return back()->withErrors([
                        'message' => __('messages.incorrect_password'),
                    ]);

            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        }
    }

    /**
     * Registration Form
     *
     * @return \Illuminate\View\View
     */

    public function showRegistrationForm(){
        return Inertia::render('register');
    }

    /**
     * To register job seeker or employer
     *
     * @return \Illuminate\View\View
     */
    public function register(Request $request){
        
        $data = $request->all();
        $redirect_page = $request->path();
        $credentials = ["email"=>$data['email'],'password'=>$data['password']];
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()){
            return $this->sendValidationErrors($redirect_page,$validator->errors());
        }else{
            try{
                try{
                    $data = $request->all();
                    $check_exists =  User::where('email', '=', $data['email'])->count();
                }catch (ModelNotFoundException $e){
                    return $this->sendErrorResponse($redirect_page,$e->getMessage());
                }

                if ($check_exists > 0) {
                    $message = __('messages.user_already_registered');
                    return $this->sendErrorResponse($redirect_page,$message);
                }else{
                    try{
                            $user = User::create([
                                'uuid'  => Str::uuid(),
                                'email' => $data['email'],
                                'role' => $data['user_type'],
                                'password' => Hash::make($data['password']),
                            ]);
                            
                            $token = Str::random(64);
  
                            UserVerify::create([
                                  'user_id' => $user->id, 
                                  'token' => $token
                                ]);
                      
                            Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($user){
                                  $message->to($user->email);
                                  $message->subject(__('messages.verification_email'));
                              });

                            return Redirect::route('thankyou');
                    }catch (ModelNotFoundException $e){
                        return $this->sendErrorResponse($redirect_page,$e->getMessage());
                    }
                    $data = [
                        'email' => $data['email'],
                    ];
                    return $this->sendSuccessResponse($redirect_page,__('messages.user_registeration'),$data);
                }        
            }catch (\Exception $e) {
                $message = $e->getMessage();
                return $this->sendErrorResponse($redirect_page,$message);
            }
        } 
    }

     /**
     * Thankyou page after registeration
     *
     * @return \Illuminate\View\View
     */
    public function thankyou()
    {
        return Inertia::render('thankyou');
    }

     /**
     * Email Verification after Registeration
     *
     * @return Login
     */

    public function verifyAccount($token)
    {
        $redirect_page = 'login';
        try{
            $verifyUser = UserVerify::where('token', $token)->first();
        }catch (ModelNotFoundException $e){
            return $this->sendErrorResponse($redirect_page,$e->getMessage());
        }
  
        $message = __('messages.not_identified');
        
        try{
            if(!is_null($verifyUser) ){
                $user = $verifyUser->user;
                if(!$user->is_email_verified) {
                    $verifyUser->user->is_email_verified = 1;
                    $verifyUser->user->email_verified_at = Carbon::now();
                    $verifyUser->user->save();
                    $message = __('messages.email_verified');
                } else {
                    $message = __('messages.email_already_verified');
                }
            }

            return $this->sendSuccessResponse($redirect_page,$message);

        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse($redirect_page,$message);
        }
        
    }

    /**
     * Remove all sessions
     *
     * @return Login
     */

    public function logout(Request $request)
    {
        $redirect_page = 'login';
        try{
            Auth::logout();
            return redirect('/'.$redirect_page);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse($redirect_page,$message);
        }
           
    }
}
