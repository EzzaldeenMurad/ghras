<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['image_path', 'title', 'consultant_id'];

    public function consultant()
    {
        return $this->belongsTo(User::class,);
    }
}
