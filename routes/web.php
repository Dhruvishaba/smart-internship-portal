<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| STUDENT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('student')->group(function () {

    Route::get('/dashboard', [StudentController::class, 'index'])
        ->name('student.dashboard');

    Route::get('/profile', [StudentController::class, 'profile'])
        ->name('student.profile');

    Route::post('/profile/update', [StudentController::class, 'updateProfile'])
        ->name('student.profile.update');

    Route::get('/search', [StudentController::class, 'search'])
        ->name('student.search');

    Route::get('/internship/{id}', [InternshipController::class, 'show'])
        ->name('internship.show');
Route::get('/check-skill/{id}', [StudentController::class, 'checkSkill']);

    Route::post('/apply/{id}', [StudentController::class, 'apply'])
        ->name('student.apply');

    Route::get('/my-applications', [StudentController::class, 'myApplications'])
        ->name('student.applications');
});


/*
|--------------------------------------------------------------------------
| COMPANY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('company')->group(function () {

    Route::get('/dashboard', [CompanyController::class, 'dashboard'])
        ->name('company.dashboard');

    Route::get('/search', [CompanyController::class, 'search'])
        ->name('company.search');

    Route::get('/profile/edit', [CompanyController::class, 'editProfile'])
        ->name('company.profile.edit');

    Route::post('/profile/update', [CompanyController::class, 'updateProfile'])
        ->name('company.profile.update');

    Route::get('/internships/create', [InternshipController::class, 'create'])
        ->name('internships.create');

    Route::post('/internships/store', [InternshipController::class, 'store'])
        ->name('internships.store');

    Route::get('/applications', [ApplicationController::class, 'companyApplications'])
        ->name('company.applications');

    Route::post('/company/accept/{id}', [CompanyController::class, 'accept'])->name('company.accept');
    Route::post('/company/reject/{id}', [CompanyController::class, 'reject'])->name('company.reject');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // STUDENTS
    Route::get('/students', [AdminController::class,'students'])
        ->name('admin.students');

    Route::get('/delete-student/{id}', [AdminController::class,'deleteStudent'])
        ->name('admin.delete.student');

    // 🔴 Deactivate Student
    Route::get('/student/deactivate/{id}', [AdminController::class,'deactivateStudent'])
        ->name('admin.student.deactivate');

    // 🟢 Activate Student
    Route::get('/student/activate/{id}', [AdminController::class,'activateStudent'])
        ->name('admin.student.activate');


    // COMPANIES
    Route::get('/companies', [AdminController::class, 'companies'])
        ->name('admin.companies');

    Route::get('/delete-company/{id}', [AdminController::class, 'deleteCompany'])
        ->name('admin.delete.company');

    // 🔴 Deactivate Company
    Route::get('/company/deactivate/{id}', [AdminController::class,'deactivateCompany'])
        ->name('admin.company.deactivate');

    // 🟢 Activate Company
    Route::get('/company/activate/{id}', [AdminController::class,'activateCompany'])
        ->name('admin.company.activate');


    // INTERNSHIPS
    Route::get('/internships', [AdminController::class, 'internships'])
        ->name('admin.internships');

    Route::get('/delete-internship/{id}', [AdminController::class,'deleteInternship'])
        ->name('admin.delete.internship');

    // APPLICATIONS
    Route::get('/applications', [AdminController::class, 'applications'])
        ->name('admin.applications');

    Route::post('/applications/approve/{id}', [AdminController::class, 'approveApplication'])
        ->name('admin.application.approve');

    Route::post('/applications/reject/{id}', [AdminController::class, 'rejectApplication'])
        ->name('admin.application.reject');

    Route::delete('/applications/delete/{id}', [AdminController::class, 'deleteApplication'])
        ->name('admin.application.delete');

    // REPORTS
    Route::get('/reports', [AdminController::class, 'reports'])
        ->name('admin.reports');

    Route::get('/reports/export/{type}', [AdminController::class, 'exportReport'])
        ->name('admin.reports.export');
});