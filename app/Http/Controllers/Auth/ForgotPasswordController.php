<?php 
  
namespace App\Http\Controllers\Auth; 
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
  
class ForgotPasswordController extends Controller
{
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return Inertia::render('forgot_password');
         
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ])->validate();
  
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
  
          Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });

          $response = ['status' => $this->errorStatus,'message' => 'We have e-mailed your password reset link!','responseCode'=> $this->errorResponse];
          return inertia('forgot_password', [
              'errors' => $response,
          ]);
  
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm(Request $request,$token) { 
         
        return inertia('reset_password', [
            'user' => [
                'token' => $request->token
            ],
        ]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request,$token)
      {
          $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ])->validate();
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                //'email' => $request->email, 
                                'token' => $token
                              ])
                              ->first();
          //echo '<pre>';                
          if(!$updatePassword){
            return inertia('reset_password', [
                'errors' => ['message'=>'Invalid token!'],
            ]);
          }
          //die($updatePassword);
          $user = User::where('email', $updatePassword->email)
                      ->update(['password' => Hash::make($request->password)]);
            //die('user');
          DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();
          //die('--');
         //$response = ['errors' => ['message'=> 'Your password has been changed!']];
          //die('--');
        return Redirect::route('login'); 
      }
}
