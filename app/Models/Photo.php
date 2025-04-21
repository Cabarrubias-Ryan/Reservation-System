<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'picture';
    protected $fillable = [
        'id',
        'v_code',
        'path',
        'uploaded_at',
        'updated_at',
        'deleted_at',
        'venues_id'
    ];
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venues_id');
    }
}
