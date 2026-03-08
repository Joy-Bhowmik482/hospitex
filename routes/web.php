<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorScheduleController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

// Patient Management Routes
Route::resource('patients', PatientController::class);

// Doctor & Staff Management Routes
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('staff', StaffController::class);
Route::resource('doctors', DoctorController::class);
Route::resource('doctor-schedules', DoctorScheduleController::class);

