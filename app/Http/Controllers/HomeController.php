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

    public function index(){
        
        if(!Auth::check())
        {
            $response = ['status' => $this->errorStatus,'message' => 'unauthorized','responseCode'=> $this->errorResponse];
            return inertia('login', [
                'errors' => $response,
            ]);
        }

        $user = Auth::user();
        return Inertia::render('dashboard', [
            'user' => [
                'email' => $user->email,
                'name' => $user->email,
            ],
        ]);
    }
}
