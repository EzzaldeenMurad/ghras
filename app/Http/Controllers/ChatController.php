<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Events\NewMessage;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Consultant;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class ChatController extends Controller
{

    public function index()
    {
        $users = User::withCount(['receivedMessages' => function ($query) {
            $query->where('is_read', false);
        }])->get();

        $users = User::all();
        return view('chat', compact('users'));
    }

    public function getMessages(Request $request)
    {
        $authId = Auth::id();
        $otherUserId = $request->query('user_id');

        $messages = Message::where(function ($query) use ($authId, $otherUserId) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $otherUserId);
        })->orWhere(function ($query) use ($authId, $otherUserId) {
            $query->where('sender_id', $otherUserId)
                ->where('receiver_id', $authId);
        })
            ->orderBy('created_at')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json(['success' => true, 'message' => $message]);
    }
}
