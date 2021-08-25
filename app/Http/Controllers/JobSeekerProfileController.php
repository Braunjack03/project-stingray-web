<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Inertia\Inertia;

class JobSeekerProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Profile
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
            return Inertia::render('profile', [
                'user' => [
                    'email' => $user->email,
                    'name' => $user->email,
                ],
            ]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }

    /**
     * To register job seeker or employer
     *
     * @return \Illuminate\View\View
     */
    public function updateProfile(Request $request){
        
          
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }

        $data = $request->all();
       // echo '<pre>';
        //$user_id = Auth::id();
        //echo $user_id;
        //print_r($data);
        $redirect_page = $request->path();
        $credentials = ["name"=>$data['name']];
        $validator = Validator::make($credentials, [
            'name' => 'required',
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
                            $user = User::update([
                                'name' => $data['name'],
                            ]);

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

}
