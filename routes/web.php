<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Route Dashboard
    Route::get('/doctor/dashboard', [DashboardController::class, 'doctorDashboard'])->name('doctor.dashboard');
    Route::get('/patient/dashboard', [DashboardController::class, 'patientDashboard'])->name('patient.dashboard');
    
    // Route Fitur Dokter (Tambah Pasien & Buat Program)
    Route::post('/doctor/patient/store', [DashboardController::class, 'storePatient'])->name('doctor.patient.store');
    Route::post('/doctor/assignment/store', [DashboardController::class, 'storeAssignment'])->name('doctor.assignment.store');
    
    // Route Fitur AI Camera
  Route::get('/latihan/{assignmentId}', [LatihanController::class, 'index'])->name('latihan');
    Route::post('/latihan/save', [LatihanController::class, 'saveSession'])->name('latihan.save');

    // Route untuk sistem Chat
    Route::get('/chat/fetch/{partnerId}', [ChatController::class, 'fetch']);
    Route::post('/chat/send', [ChatController::class, 'send']);
});