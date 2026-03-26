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
use App\Http\Controllers\GoogleController;
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::middleware('auth')->group(function () {
    Route::get('/doctor/dashboard', [DashboardController::class, 'doctorDashboard'])->name('doctor.dashboard');
    Route::get('/patient/dashboard', [DashboardController::class, 'patientDashboard'])->name('patient.dashboard');
    Route::post('/doctor/patient/store', [DashboardController::class, 'storePatient'])->name('doctor.patient.store');
    Route::get('/doctor/report/download/{patientId}', [DashboardController::class, 'downloadReport'])->name('doctor.report.download');
    Route::post('/doctor/assignment/store', [DashboardController::class, 'storeAssignment'])->name('doctor.assignment.store');
  Route::get('/latihan/{assignmentId}', [LatihanController::class, 'index'])->name('latihan');
    Route::post('/latihan/save', [LatihanController::class, 'saveSession'])->name('latihan.save');
    Route::get('/chat/fetch/{partnerId}', [ChatController::class, 'fetch']);
    Route::post('/chat/send', [ChatController::class, 'send']);
});