<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PatientProfile;
use App\Models\Exercise;
use App\Models\Assignment;
use App\Models\SessionLog;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $doctor = User::create([
            'name' => 'Budi Santoso',
            'email' => 'dokter@rehab.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        $patient = User::create([
            'name' => 'Slamet Riyadi',
            'email' => 'pasien@rehab.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        PatientProfile::create([
            'user_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'date_of_birth' => '1965-04-12',
            'gender' => 'male',
            'medical_diagnosis' => 'Post-Stroke Iskemik Ringan',
        ]);

        $exercise = Exercise::create([
            'name' => 'Elbow Flexion (Tekuk Siku)',
            'description' => 'Latihan untuk mengembalikan rentang gerak siku pasca stroke.',
            'target_joint' => 'left_elbow',
            'target_angle' => 140,
            'video_url' => 'https://example.com/video.mp4',
        ]);

        $assignment = Assignment::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'exercise_id' => $exercise->id,
            'target_reps' => 15,
            'due_date' => Carbon::now()->addDays(7),
            'is_completed' => false,
        ]);

        for ($i = 6; $i >= 1; $i--) {
            SessionLog::create([
                'assignment_id' => $assignment->id,
                'achieved_reps' => rand(10, 15),
                'max_angle_reached' => rand(120, 155),
                'accuracy_score' => rand(75, 98),
                'duration_seconds' => rand(300, 600),
                'created_at' => Carbon::now()->subDays($i),
                'updated_at' => Carbon::now()->subDays($i),
            ]);
        }
    }
}