<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'consultant_id',
        'price',
    ];

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function consultantOrders()
    {
        return $this->hasMany(ConsultantOrder::class);
    }
}
