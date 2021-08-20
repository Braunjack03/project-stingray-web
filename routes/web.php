<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\JobPost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;

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

Route::get('/contact', function() {
    return Inertia::render('contact');
});

Route::get('/register', function() {
    return Inertia::render('register');
});

Route::get('/forgot-password', function() {
    return Inertia::render('forgot_password');
});

Route::get('/login', function() {
    return Inertia::render('login');
});

Route::get('thankyou', [AuthController::class, 'thankyou'])->name('thankyou');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/', function() {
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
