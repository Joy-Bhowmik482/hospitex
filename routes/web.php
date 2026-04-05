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
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\BedAllocationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InsuranceProviderController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

//----Registration Routes----
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//----Protected Routes----
Route::group(['middleware' => 'auth'], function () {

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

// Appointments & Queue Management Routes
Route::resource('appointments', AppointmentController::class);
Route::get('appointments-queue', [AppointmentController::class, 'queue'])->name('appointments.queue');
Route::post('appointments/{appointment}/change-status', [AppointmentController::class, 'changeStatus'])->name('appointments.changeStatus');

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

// Inventory & Assets Routes
Route::resource('assets', AssetController::class);
Route::resource('inventory-items', InventoryItemController::class);
Route::resource('inventory-movements', InventoryMovementController::class);
Route::post('inventory-items/{inventoryItem}/add-movement', [InventoryItemController::class, 'addMovement'])->name('inventory-items.add-movement');

// Reports Routes (Custom routes must come BEFORE resource route)
Route::get('reports/create-patient', [ReportController::class, 'createPatient'])->name('reports.create-patient');
Route::get('reports/create-financial', [ReportController::class, 'createFinancial'])->name('reports.create-financial');
Route::get('reports/create-daily', [ReportController::class, 'createDaily'])->name('reports.create-daily');
Route::get('reports/create-lab', [ReportController::class, 'createLab'])->name('reports.create-lab');
Route::get('reports/create-pharmacy', [ReportController::class, 'createPharmacy'])->name('reports.create-pharmacy');
Route::get('reports/{report}/export', [ReportController::class, 'export'])->name('reports.export');
Route::resource('reports', ReportController::class);

});