<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PatientProfile;
use App\Models\SessionLog;
use App\Models\Assignment;
use Barryvdh\DomPDF\Facade\Pdf;
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

        // 1. Tangkap semua error validasi untuk melihat apa yang salah
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                // PERBAIKAN DI SINI: medical_diagnosis boleh kosong/opsional jika tidak diisi lengkap dari form
                'medical_diagnosis' => 'nullable|string', 
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika gagal validasi, kembalikan error spesifiknya
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            // 2. Gunakan DB Transaction agar jika satu tabel gagal, yang lain di-rollback
            \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'patient', // Pastikan kolom role ini ada di tabel users kamu
                ]);

                PatientProfile::create([
                    'user_id' => $user->id,
                    'doctor_id' => Auth::id(),
                    'date_of_birth' => $request->date_of_birth,
                    'gender' => $request->gender,
                    'medical_diagnosis' => $request->medical_diagnosis ?? 'Belum ada diagnosis',
                ]);
            });

            return back()->with('success', 'Pasien '.$request->name.' berhasil ditambahkan!');

        } catch (\Exception $e) {
            // 3. Menangkap error database (misalnya Foreign Key Constraint atau kolom tidak ada)
            return back()->withErrors(['db_error' => 'Gagal menyimpan ke database: ' . $e->getMessage()])->withInput();
        }
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
    public function storeAssignment(Request $request)
    {
        if (Auth::user()->role !== 'doctor') abort(403);

        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'exercise_name' => 'required|string',
            'target_reps' => 'required|integer|min:1',
            'sessions_per_week' => 'required|integer|min:1|max:7',
        ]);

        // Cari atau buat jenis latihan baru
        $exercise = \App\Models\Exercise::firstOrCreate(
            ['name' => $request->exercise_name],
            [
                'description' => 'Latihan ' . $request->exercise_name . ' untuk pemulihan.',
                'target_joint' => 'custom',
                'target_angle' => 160,
            ]
        );

        // Buat tugas (Assignment) baru untuk pasien
        Assignment::create([
            'doctor_id' => Auth::id(),
            'patient_id' => $request->patient_id,
            'exercise_id' => $exercise->id,
            'target_reps' => $request->target_reps,
            'due_date' => \Carbon\Carbon::now()->addDays(7),
            'is_completed' => false,
        ]);

        return back()->with('success', 'Program latihan berhasil diberikan ke pasien!');
    }
public function downloadReport($patientId)
{
    // 1. Ambil profil pasien berdasarkan user_id
    $patient = \App\Models\PatientProfile::with('user')->where('user_id', $patientId)->first();

    if (!$patient) {
        return "Data pasien tidak ditemukan.";
    }

    // 2. Ambil riwayat latihan (SessionLog) yang terhubung ke pasien ini
    // Kita ambil melalui relasi Assignment
    $sessions = \App\Models\SessionLog::with('assignment.exercise')
                ->whereHas('assignment', function($q) use ($patientId) {
                    $q->where('patient_id', $patientId);
                })
                ->latest()
                ->get();

    // 3. Siapkan data untuk PDF
    $data = [
        'patient' => $patient,
        'sessions' => $sessions,
        'date' => date('d/m/Y'),
    ];

    // 4. Load view dan download
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('doctor.report_pdf', $data);
    
    return $pdf->download('Laporan_Terapi_' . str_replace(' ', '_', $patient->user->name) . '.pdf');
}
}