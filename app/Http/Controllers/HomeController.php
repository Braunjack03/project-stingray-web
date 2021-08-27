<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Inertia\Inertia;

class HomeController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
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

        try{
            $user = Auth::user();
            return Inertia::render('dashboard', [
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
}
