<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetch($partnerId)
    {
        $myId = Auth::id();
        $messages = Message::where(function($q) use ($myId, $partnerId) {
            $q->where('sender_id', $myId)->where('receiver_id', $partnerId);
        })->orWhere(function($q) use ($myId, $partnerId) {
            $q->where('sender_id', $partnerId)->where('receiver_id', $myId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);
        return response()->json($msg);
    }
}