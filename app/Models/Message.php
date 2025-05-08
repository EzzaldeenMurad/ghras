<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
    ];

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of the message.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public static function getUsersWhoSentMessagesToConsultant($consultantId)
    {
        return self::where('receiver_id', $consultantId)
            ->distinct('sender_id')  // التأكد من جلب كل مستخدم فقط مرة واحدة
            ->get(['sender_id']);  // جلب معرّف المستخدمين الذين أرسلوا رسائل
    }
}
