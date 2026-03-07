<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\ApplicationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', function () {
    return redirect('/login');
});


// ================= AUTH =================

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ================= STUDENT ROUTES =================

Route::middleware(['auth'])->group(function () {

    // student dashboard (show internships)
    Route::get('/student/dashboard', [StudentController::class, 'index'])
        ->name('student.dashboard');

    // student profile
    Route::get('/student/profile', [StudentController::class, 'profile'])
        ->name('student.profile');

    Route::post('/student/profile/update', [StudentController::class, 'updateProfile'])
        ->name('student.profile.update');

    Route::post('/student/upload-photo', [StudentController::class, 'uploadPhoto'])
        ->name('student.upload.photo');

    // search internship/company
    Route::get('/student/search', [StudentController::class, 'search'])
        ->name('student.search');

    // apply internship
    Route::post('/apply/{id}', [ApplicationController::class, 'apply'])
        ->name('apply.internship');

});


// ================= COMPANY ROUTES =================

Route::middleware(['auth'])->group(function () {

    // company dashboard
    Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])
        ->name('company.dashboard');

    // search students
    Route::get('/company/search', [CompanyController::class, 'search'])
        ->name('company.search');

    // company profile
    Route::get('/company/profile/edit', [CompanyController::class, 'editProfile'])
        ->name('company.profile.edit');

    Route::post('/company/profile/update', [CompanyController::class, 'updateProfile'])
        ->name('company.profile.update');

    // internship create
    Route::get('/company/internships/create', [InternshipController::class, 'create'])
        ->name('internships.create');

    Route::post('/company/internships/store', [InternshipController::class, 'store'])
        ->name('internships.store');

    // company see applications
   Route::get('/company/applications', [ApplicationController::class, 'companyApplications'])
    ->name('company.applications');

Route::post('/application/accept/{id}', [ApplicationController::class, 'accept'])
    ->name('application.accept');

Route::post('/application/reject/{id}', [ApplicationController::class, 'reject'])
    ->name('application.reject');
});