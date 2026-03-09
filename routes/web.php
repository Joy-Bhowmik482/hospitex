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
use App\Http\Controllers\WardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\BedAllocationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InsuranceProviderController;

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

// Ward Management Routes
Route::resource('wards', WardController::class);
Route::resource('rooms', RoomController::class);
Route::resource('beds', BedController::class);
Route::resource('admissions', AdmissionController::class);
Route::resource('bed-allocations', BedAllocationController::class);

// Patient Billing Routes
Route::resource('services', ServiceController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('payments', PaymentController::class);
Route::resource('insurance-providers', InsuranceProviderController::class);

