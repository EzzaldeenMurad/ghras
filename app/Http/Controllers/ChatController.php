<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $consultantId = $request->input('consultant_id');
        $currentUserId = Auth::id();

        // جلب المستشارين الذين تمت مراسلتهم من قبل المستخدم الحالي
        $consultants = User::where('role', 'consultant')
            ->whereHas('receivedMessages', function ($query) use ($currentUserId) {
                $query->where('sender_id', $currentUserId);
            })
            ->orWhereHas('sentMessages', function ($query) use ($currentUserId) {
                $query->where('receiver_id', $currentUserId);
            })
            ->withCount(['receivedMessages as unread_messages_count' => function ($query) use ($currentUserId) {
                $query->where('is_read', false)
                    ->where('sender_id', $currentUserId);
            }])
            ->get();

        // إذا تم تحديد مستشار معين ولم يكن موجوداً في القائمة، نضيفه
        if ($consultantId) {
            $specificConsultant = User::where('id', $consultantId)
                ->where('role', 'consultant')
                ->first();

            if ($specificConsultant && !$consultants->contains('id', $consultantId)) {
                $specificConsultant->unread_messages_count = 0;
                $consultants->push($specificConsultant);
            }
        }

        // إضافة آخر رسالة لكل مستشار
        $consultants->transform(function ($consultant) use ($currentUserId) {
            $consultant->last_message = $consultant->lastChatMessage($currentUserId);
            return $consultant;
        });

        return view('chat', ['users' => $consultants]);
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $authId = Auth::id();
        $otherUserId = $request->user_id;

        $messages = Message::where(function ($query) use ($authId, $otherUserId) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $otherUserId);
        })
            ->orWhere(function ($query) use ($authId, $otherUserId) {
                $query->where('sender_id', $otherUserId)
                    ->where('receiver_id', $authId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        // تحميل العلاقات للمرسل والمستقبل
        $message->load(['sender', 'receiver']);

        // بث الرسالة
        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'sender_id' => 'nullable|exists:users,id',
            'message_id' => 'nullable|exists:messages,id'
        ]);

        if ($request->has('sender_id')) {
            Message::where('sender_id', $request->sender_id)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        if ($request->has('message_id')) {
            Message::where('id', $request->message_id)
                ->where('receiver_id', Auth::id())
                ->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }
}
