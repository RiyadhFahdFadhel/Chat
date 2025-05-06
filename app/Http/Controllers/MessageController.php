<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Send a new message
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'text' => 'required|string',
        ]);
    
        $message = Message::create($validated);
    
        // 🔥 Fire the real-time event
        broadcast(new MessageSent($message))->toOthers();
    
        return response()->json($message, 201);
    }

    // Get messages between the authenticated user and another user
    public function index(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $messages = Message::where(function ($query) use ($request) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('sender_id', $request->receiver_id)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }
}

