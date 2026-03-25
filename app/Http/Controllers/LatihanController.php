<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionLog;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class LatihanController extends Controller
{
public function index($assignmentId)
    {
        // Validasi apakah assignment ini benar milik pasien yang sedang login
        $assignment = \App\Models\Assignment::where('id', $assignmentId)
                        ->where('patient_id', \Illuminate\Support\Facades\Auth::id())
                        ->firstOrFail();

        return view('latihan', compact('assignmentId', 'assignment'));
    }
    public function saveSession(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'achieved_reps' => 'required|numeric',
            'max_angle_reached' => 'required|numeric',
            'accuracy_score' => 'required|numeric',
            'duration_seconds' => 'required|numeric',
        ]);

        SessionLog::create([
            'assignment_id' => $request->assignment_id,
            'achieved_reps' => $request->achieved_reps,
            'max_angle_reached' => $request->max_angle_reached,
            'accuracy_score' => $request->accuracy_score,
            'duration_seconds' => $request->duration_seconds,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data latihan berhasil disimpan'
        ]);
    }
}