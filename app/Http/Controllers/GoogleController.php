<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Jika user sudah ada, update google_id dan login
                $user->update(['google_id' => $googleUser->id]);
                Auth::login($user);
            } else {
                // 1. Buat User baru
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt('password_dummy_123'),
                    'role' => 'patient'
                ]);

                // 2. TAMBAHAN: Otomatis buatkan PatientProfile dan ikat ke Dokter ID 1
                \App\Models\PatientProfile::create([
                    'user_id' => $newUser->id,
                    'doctor_id' => 1, // Anggap 1 adalah ID untuk Dokter Utama
                    'date_of_birth' => now(), // Default sementara
                    'gender' => 'male', // Default sementara
                    'medical_diagnosis' => 'Pasien mandiri (Daftar via Google)',
                ]);

                Auth::login($newUser);
            }

            if (Auth::user()->role === 'doctor') {
                return redirect()->route('doctor.dashboard');
            }
            return redirect()->route('patient.dashboard');

        } catch (Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Gagal login dengan Google.']);
        }
    }
}