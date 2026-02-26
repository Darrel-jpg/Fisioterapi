<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionLog;

class LatihanController extends Controller
{
    public function index()
    {
        return view('latihan');
    }

    public function saveSession(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|integer',
            'achieved_reps' => 'required|integer',
            'max_angle_reached' => 'required|numeric',
            'accuracy_score' => 'required|numeric',
            'duration_seconds' => 'required|integer'
        ]);

        SessionLog::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Sesi terapi berhasil disimpan'
        ]);
    }
}