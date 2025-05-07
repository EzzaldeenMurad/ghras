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
}
