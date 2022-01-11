<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Inertia\Inertia;
use App\Models\ActivityLog;

class EmployerController extends Controller
{    
    public function __construct()
    {
        $this->middleware(['auth','employer']);
    }
    /**
     * Dashboard
     *
     * @return \Illuminate\View\View
     */

    public function index(){
        
        if(!Auth::check())
        {
            return $this->sendErrorResponse('login',__('messages.unauthorized'));
        }
        if(isset($_SERVER['HTTP_REFERER'])){
            if(strpos($_SERVER['HTTP_REFERER'], "billing") !== false){
               return redirect()->route('employer.profile');
            }
        }
        try{
            $user = Auth::user();
            return Inertia::render('employer/dashboard', [
                'user' => [
                    'email' => $user->email,
                    'name' => $user->email,
                    'role' => $user->role,
                    'is_email_verified' => $user->is_email_verified
                ],
            ]);
        }catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->sendErrorResponse('login',$message);
        }
    }
}
