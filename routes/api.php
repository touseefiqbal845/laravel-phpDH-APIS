<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;



// User Routes 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/check-auth', [AuthController::class, 'checkAuth'])->middleware('auth:sanctum');
Route::post('/reset-password-request', [AuthController::class, 'resetPasswordRequest']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);




// Doctor Routes 
Route::get('doctors', [DoctorController::class, 'index']);
Route::get('popular', [DoctorController::class, 'getPopularDoctors']);
Route::get('featured', [DoctorController::class, 'getFeaturedDoctors']);
Route::post('doctors', [DoctorController::class, 'create']);    
Route::get('doctors/{id}', [DoctorController::class, 'show']);
Route::put('doctors/{id}', [DoctorController::class, 'update']);
Route::delete('doctors/{id}', [DoctorController::class, 'destroy']);
    
// Patient Routes 
Route::get('patients', [PatientController::class, 'index']);       
Route::post('patients', [PatientController::class, 'create']);       
Route::get('patients/{id}', [PatientController::class, 'show']);     
Route::put('patients/{id}', [PatientController::class, 'update']);   
Route::delete('patients/{id}', [PatientController::class, 'destroy']); 


// medical-records Routes 
Route::get('medical-records', [MedicalRecordController::class, 'index']);
Route::post('medical-records', [MedicalRecordController::class, 'create']);
Route::get('medical-records/{id}', [MedicalRecordController::class, 'show']);
Route::put('medical-records/{id}', [MedicalRecordController::class, 'update']);
Route::delete('medical-records/{id}', [MedicalRecordController::class, 'delete']);


// Health-records Routes 
Route::get('health-checks', [HealthCheckController::class, 'index']);
Route::post('health-checks', [HealthCheckController::class, 'create']);
Route::get('health-checks/{id}', [HealthCheckController::class, 'show']);
Route::put('health-checks/{id}', [HealthCheckController::class, 'update']);
Route::delete('health-checks/{id}', [HealthCheckController::class, 'destroy']);


// Appointments Routes 
Route::get('appointments', [AppointmentController::class, 'index']);
Route::post('appointments', [AppointmentController::class, 'create']);
Route::get('appointments/{id}', [AppointmentController::class, 'show']);
Route::put('appointments/{id}', [AppointmentController::class, 'update']);
Route::delete('appointments/{id}', [AppointmentController::class, 'destroy']);


