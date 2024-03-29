<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\JobPost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\EmployerProfileController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ArticleController;

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

Route::get('terms', [HomeController::class, 'terms']);

Route::get('contact', [HomeController::class, 'contact']);

Route::get('privacy', [HomeController::class, 'privacy']);

Route::get('for_employers', [HomeController::class, 'for_employers']);

Route::get('about_us', [HomeController::class, 'about_us']);

Route::get('pricing', [HomeController::class, 'pricing']);

Route::post('contact', [HomeController::class, 'contactSubmit'])->name('contact');

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
 
Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('jobs', [JobPostController::class, 'jobs'])->name('jobs');

Route::get('articles', [ArticleController::class, 'index'])->name('articles');

Route::get('articles/{slug}', [ArticleController::class, 'show'])->name('article_details');

Route::get('companies', [CompanyProfileController::class, 'companies'])->name('companies');

Route::post('/search', [HomeController::class, 'home'])->name('search');

Route::get('/jobs/{company}/{slug}', [JobPostController::class, 'showJobPost'])->name('home');

Route::get('/companies/{company}', [CompanyProfileController::class, 'showCompany'])->name('company');

Route::get('claim-profile/{id}', [CompanyProfileController::class, 'claimProfile'])->name('claim.profile')->middleware('employer');

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

    Route::get('edit-company',[CompanyProfileController::class,'edit'])->name('edit.company');

    Route::get('photo-gallery',[CompanyProfileController::class,'photoGallery'])->name('photos.gallery');

    Route::post('photo-gallery',[CompanyProfileController::class,'updatePhotoGallery'])->name('update.gallery');

    Route::post('photo-gallery-order',[CompanyProfileController::class,'updatePhotoGalleryOrder'])->name('sort.gallery');

    Route::get('delete-gallery-photo',[CompanyProfileController::class,'destroyPhotoGalleryImage'])->name('delete.photo');

    Route::post('edit-company',[CompanyProfileController::class,'update'])->name('update.company');

    Route::get('jobs', [JobPostController::class, 'index'])->name('employer.jobs');

    Route::get('create-job', [JobPostController::class, 'create'])->name('jobs.create');

    Route::post('create-job', [JobPostController::class, 'store'])->name('jobs.submit');

    Route::get('edit-job', [JobPostController::class, 'edit'])->name('jobs.edit');

    Route::post('edit-job', [JobPostController::class, 'update'])->name('jobs.update');

    Route::get('delete-job', [JobPostController::class, 'destroy'])->name('jobs.delete');

});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {

    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('jobs', [AdminController::class, 'jobs'])->name('admin.jobs');

    Route::get('companies', [AdminController::class, 'companies'])->name('admin.companies');

    Route::get('employers', [AdminController::class, 'employers'])->name('admin.employers');

    Route::get('job_seekers', [AdminController::class, 'job_seekers'])->name('admin.job_seekers');

});

Route::get('/{vue_capture?}', function () {
    return Inertia::render('404');
})->where('vue_capture', '[\/\w\.-]*');