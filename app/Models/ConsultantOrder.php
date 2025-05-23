<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantOrder extends Model
{
    protected $table = 'consultant_orders';

    protected $fillable = [
        'consultation_id',
        'seller_id',
        'subject',
        'description',
        'status',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'قيد الانتظار';
            case 'accepted':
                return 'في انتظار الدفع';
            case 'cancelled':
                return 'ملغي';
            default:
                return 'تم الدفع';
        }
    }

    /**
     * Get the status color for display.
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'pending';
            case 'accepted':
                return 'secondary';
            case 'cancelled':
                return 'danger';
            default:
                return 'paid';
        }
    }
}
