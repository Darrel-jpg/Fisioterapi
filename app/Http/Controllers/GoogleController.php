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
                $user->update(['google_id' => $googleUser->id]);
                Auth::login($user);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt('password_dummy_123'),
                    'role' => 'patient'
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