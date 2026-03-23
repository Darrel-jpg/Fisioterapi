<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PatientProfile;
use App\Models\SessionLog;
use App\Models\Assignment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function doctorDashboard()
    {
        if (Auth::user()->role !== 'doctor') abort(403);
        
        $doctorId = Auth::user()->id;
        
        $totalPatients = PatientProfile::where('doctor_id', $doctorId)->count();
        
        $totalSessions = SessionLog::whereHas('assignment', function($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->count();
        
        $avgAccuracy = SessionLog::whereHas('assignment', function($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->avg('accuracy_score') ?? 0;

        $patientsList = PatientProfile::with('user')->where('doctor_id', $doctorId)->latest()->get();

        return view('doctor.dashboard', compact('totalPatients', 'totalSessions', 'avgAccuracy', 'patientsList'));
    }

    public function storePatient(Request $request)
    {
        if (Auth::user()->role !== 'doctor') abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'medical_diagnosis' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        PatientProfile::create([
            'user_id' => $user->id,
            'doctor_id' => Auth::id(),
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'medical_diagnosis' => $request->medical_diagnosis,
        ]);

        return back()->with('success', 'Pasien '.$request->name.' berhasil ditambahkan!');
    }

    public function patientDashboard()
    {
        if (Auth::user()->role !== 'patient') abort(403);

        $patientId = Auth::user()->id;

        $activeAssignments = Assignment::with('exercise')
            ->where('patient_id', $patientId)
            ->where('is_completed', false)
            ->get();
            
        $recentSessions = SessionLog::with('assignment.exercise')
            ->whereHas('assignment', function($q) use ($patientId) {
                $q->where('patient_id', $patientId);
            })->latest()->take(3)->get();

        $avgAccuracy = SessionLog::whereHas('assignment', function($q) use ($patientId) {
            $q->where('patient_id', $patientId);
        })->avg('accuracy_score') ?? 0;

        return view('patient.dashboard', compact('activeAssignments', 'recentSessions', 'avgAccuracy'));
    }
}