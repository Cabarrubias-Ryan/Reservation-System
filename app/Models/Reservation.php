<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservation';
    protected $fillable = [
        'id',
        'name',
        'address',
        'dataschedule',
        'amount',
        'status',
        'reserve_by',
        'isConfirm',
        'created_at',
        'updated_at',
        'deleted_at',
        'logs_id',
        'venues_id'
    ];
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venues_id');
    }
}
