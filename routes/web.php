<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\JobPost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\EmployerProfileController;
use App\Http\Controllers\CompanyProfileController;


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

Route::get('/dashboard', function() {
    return Inertia::render('dashboard');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');

Route::get('thankyou', [AuthController::class, 'thankyou'])->name('thankyou');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm']);
Route::post('forgot-password', [ForgotPasswordController::class, 'submitForgotPasswordForm'])->name('forgot.password.post'); 

Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify'); 

Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password/{token}', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
 
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


Route::middleware(['auth','jobseeker'])->group(function () {

    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('profile', [JobSeekerProfileController::class, 'index'])->name('profile');

    Route::post('profile', [JobSeekerProfileController::class, 'updateProfile'])->name('profile.update');

});

Route::group(['prefix' => 'employer', 'middleware' => ['auth','employer']], function() {

    Route::get('dashboard', [EmployerController::class, 'index'])->name('dashboard');

    Route::get('profile', [EmployerProfileController::class, 'index'])->name('employer.profile');

    Route::post('profile', [EmployerProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('create-company',[CompanyProfileController::class,'create'])->name('company.create');

    Route::post('create-company',[CompanyProfileController::class,'store'])->name('company.store');

});