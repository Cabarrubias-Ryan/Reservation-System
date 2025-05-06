<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = [
        'id',
        'payment_method',
        'amount',
        'isCard',
        'created_at',
        'updated_at',
        'deleted_at',
        'reservation_id',
        'users_id',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
