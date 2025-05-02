<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantImage extends Model
{
    protected $fillable = ['image', 'consultant_id'];

    public function consultant()
    {
        return $this->belongsTo(User::class,);
    }
}
