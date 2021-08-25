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
       * Forgot Password Form
       *
       * @return \Illuminate\View\View
       */
      public function showForgotPasswordForm()
      {
         return Inertia::render('forgot-password');
      }
  
      /**
       * Forgot Password Submission
       *
       * @return response()
       */
      public function submitForgotPasswordForm(Request $request)
      {
          $redirect_page = $request->path();
          $data = ['email'=>$request->all()['email']];
          $validator = Validator::make($data, [
            'email' => 'required|email|exists:users',
          ]);

        if ($validator->fails()){
            return $this->sendValidationErrors($redirect_page,$validator->errors());
        }else{
            $token = Str::random(64);

            try{
              DB::table('password_resets')->insert([
                  'email' => $request->email, 
                  'token' => $token, 
                  'created_at' => Carbon::now()
                ]);
            }catch (ModelNotFoundException $e){
              return $this->sendErrorResponse($redirect_page,$e->getMessage());
            }
            
            try{
                Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject(__('messages.reset_password_email'));
                });

                return $this->sendSuccessResponse($redirect_page,__('messages.password_reset_link'));

            }catch (\Exception $e) {
              return $this->sendErrorResponse($redirect_page,$e->getMessage());
          }
        }
  
      }
      /**
       * Reset Password Form
       *
       * @return \Illuminate\View\View
       */
      public function showResetPasswordForm(Request $request,$token) { 
        $redirect_page = 'login';
        try{
          $updatePassword = DB::table('password_resets')->where(['token' => $token])->first();
        }catch (ModelNotFoundException $e){
          return $this->sendErrorResponse($redirect_page,$e->getMessage());
        }              
        if(!$updatePassword){
          return $this->sendErrorResponse($redirect_page,__('messages.invalid_token'));
          //return Redirect::route('login'); 
          //return $this->sendErrorResponse($redirect_page,__('messages.invalid_token'));
        }
         
        return inertia('reset-password', [
            'user' => [
                'token' => $request->token
            ],
        ]);
      }
  
      /**
       * Reset Password Form Submission
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request,$token)
      { 
          $redirect_page = 'reset-password';
          $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
          ]);
            
          if ($validator->fails()){

            $error = json_decode($validator->errors());
            if(!empty($error)){
                foreach($error as $key => $value){
                    $response = ['status' => $this->errorStatus,'message' => $value[0],'data'=>[],'responseCode'=> $this->errorResponse];
                    return inertia($redirect_page, [
                        'errors' => $response,
                          'user' => [
                            'token' => $token
                        ],
                    ]);
                    break;
                }
            }
            
        }else{
              try{
                $updatePassword = DB::table('password_resets')->where(['token' => $token])->first();
              }catch (ModelNotFoundException $e){
                return $this->sendErrorResponse($redirect_page,$e->getMessage());
              }              
              if(!$updatePassword){
                return $this->sendErrorResponse($redirect_page,__('messages.invalid_token'));
              }
              
              try{
                $user = User::where('email', $updatePassword->email)->update(['password' => Hash::make($request->password)]);
               
                DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();
              }catch (ModelNotFoundException $e){
                return $this->sendErrorResponse($redirect_page,$e->getMessage());
              }  

            return Redirect::route('login'); 
        }
      }
}
