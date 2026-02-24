<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function doctorDashboard()
    {
        if (Auth::user()->role !== 'doctor') abort(403);
        return view('doctor.dashboard');
    }

    public function patientDashboard()
    {
        if (Auth::user()->role !== 'patient') abort(403);
        return view('patient.dashboard');
    }
}