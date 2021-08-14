<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\JobPost;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    $restaurants = [
        [
            'id' => 1,
            'name' => 'Cafe Badilico',
            'type' => 'Italian, Cafe',
            'description' => 'Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.',
            'img' => 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
            'ratings' => [
                'score' => 4.5,
                'total' => 403
            ]
        ],
        [
            'id' => 2,
            'name' => 'Grilled Cheese Master',
            'type' => 'American, Fast',
            'description' => 'Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.',
            'img' => 'https://images.unsplash.com/photo-1528736235302-52922df5c122?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8Z3JpbGxlZCUyMGNoZWVzZXxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60',
            'ratings' => [
                'score' => 4.5,
                'total' => 403
            ]
        ],
        [
            'id' => 3,
            'name' => 'Asian Bistro',
            'type' => 'Asian, Casual',
            'description' => 'Small plates - an intimate setting with 12 indoor seats plus patio seating.',
            'img' => 'https://images.unsplash.com/photo-1569246294372-ed319c674f14?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1534&q=80',
            'ratings' => [
                'score' => 4.5,
                'total' => 403
            ]
        ]
    ];

    return Inertia::render('home', ['restaurants' => $restaurants]);
});

Route::get('/contact', function() {
    return Inertia::render('contact');
});


Route::get('/job_posts', function() {
    //$job_posts = JobPost::with('company_profile')->all();
    #$job_posts = DB::table('job_posts')->join('company_profiles', 'company_profiles.id', '=', 'job_posts.company_profile_id')->get('content', 'job_posts.name', 'company_profiles.name');
    $job_posts = JobPost::join('company_profiles','job_posts.company_profile_id','company_profiles.id')
         ->select(
                  'job_posts.name as name',
                  'job_posts.content as content',
                  'company_profiles.name as company_name',
                  'job_posts.apply_url as apply_url'
          )
         ->get();




    return Inertia::render('job_posts', ['job_posts' => $job_posts]);
});
