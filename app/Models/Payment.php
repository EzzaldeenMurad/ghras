<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_method',
        'amount',
        'status',
        'order_id',
        'payment_id',
        'consultant_order_id',
        'user_id',
    ];


    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }
}
