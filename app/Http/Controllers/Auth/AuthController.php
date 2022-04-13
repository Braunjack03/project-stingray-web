<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Mail\WelcomeMessage;
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
            'password' => 'required',
        ]);
          
        if ($validator->fails()){
            return $this->sendValidationErrors($redirect_page,$validator->errors());
        }else{
            try{
                    if(Auth::attempt($credentials)) {
                        
                        $request->session()->regenerate();

                        ActivityLog::addToLog(__('activitylogs.loggedin_successfull'),'login');
                        
                        
                        if(Auth::user()->role == 1)
                        {
                            return redirect()->intended('/employer/profile');
                        }else if(Auth::user()->role == 3)
                        {
                            return redirect()->intended('/admin/dashboard');
                        }else{
                            return redirect()->intended('/profile');
                        }
                    }else{
                        $user = User::where('email',$credentials['email'])->first();
                        if($user)
                        {
                            ActivityLog::addUnAuthorizeLogs(__('activitylogs.loggedin_unsuccessfull').'by Email id: '.$credentials['email'],$user->id,'login');

                        }else{
                            ActivityLog::addUnAuthorizeLogs(__('activitylogs.loggedin_unsuccessfull').'by Email id: '.$credentials['email'],0,'login');

                        }

                        return back()->withErrors([
                            'message' => __('messages.incorrect_password'),
                        ]);
                    }

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
                            'uuid' => Str::uuid(),
                            'email' => $data['email'],
                            'role' => $data['user_type'],
                            'password' => Hash::make($data['password']),
                        ]);

                        
                        $token = Str::random(64);

                        UserVerify::create([
                                'user_id' => $user->id, 
                                'token' => $token
                            ]);
                        $roleName = $this->getRoleName($data['user_type']);    
                        ActivityLog::addUnAuthorizeLogs(__('activitylogs.record_created', ['name' => 'User','role'=>$roleName]),$user->id,'create');

                        $when = now()->addMinutes(3);

                        Mail::to($user->email)->later($when,
                            new WelcomeMessage($user)
                        );

                        Mail::to($user->email)->send(
                            new EmailVerification($user, $token)
                        );

                        return Redirect::route('thankyou');
                }catch (ModelNotFoundException $e){
                    return $this->sendErrorResponse($redirect_page,$e->getMessage());
                }
                $data = [
                    'email' => $data['email'],
                ];
                return $this->sendSuccessResponse($redirect_page,__('messages.user_registeration'),$data);
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
                    $verifyUser->user->save();
                    $message = __('messages.email_verified');
                } else {
                    $message = __('messages.email_already_verified');
                }
            }

            return $this->sendErrorResponse($redirect_page,$message);

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
