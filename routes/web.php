<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });




Route::group(['middleware' => 'auth'], function() {
    // if the user is not authenticated
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('account/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::put('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::post('/account/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.profile.pic.update');
    Rout::get("/account/password/update", [AccountController::class], "updatePassword")->name("account.password.update");
    Route::get('/job/post', [JobController::class, 'postJob'])->name('job.post');
    Route::post('/job/create', [JobController::class, 'createJob'])->name('job.create');
    Route::get('/my-jobs', [JobController::class, 'myJobs'])->name('my.jobs');
    Route::get('/job/edit/{id}', [JobController::class, 'editJob'])->name('job.edit');
    Route::put('/job/update/{id}', [JobController::class, 'updateJob'])->name('job.update');
    Route::delete("/job/delete/{id}", [JobController::class, "deleteJob"])->name("job.delete");
    Route::get("/jobs", [JobController::class, "jobs"])->name("jobs");
    Route::get("/job/details/{id}", [JobController::class, "jobDetails"])->name("job.details");
    Route::post("apply-job/{id}", [JobController::class, "jobApply"])->name("job.apply");
    Route::get("jobs/jobs-applied", [JobController::class, "jobsApplied"])->name("jobs.applied");
    Route::delete("jobs/delete-job-application", [JobController::class, "jobApplicationDelete"])->name("job.application.delete");
    Route::post("job/save", [JobController::class, "saveJob"])->name("job.save");
    Route::get("jobs/saved", [JobController::class, "savedJobs"])->name("jobs.saved");
    Route::delete("job/unsave", [JobController::class, "unsaveJob"])->name("job.unsave");
});
Route::group(['middleware' => 'guest'], function() {
    // if the user is authenticated
    Route::get('/account/register', [AccountController::class, 'register'])->name('account.register');
    Route::post('/account/process_register', [AccountController::class, 'processRegister'])->name('account.process_register');
    Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
    Route::post('/account/process_login', [AccountController::class, 'processLogin'])->name('account.process_login');
});
