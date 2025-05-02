<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'venues';
    protected $fillable = [
      'id',
      'name',
      'description',
      'price',
      'recent_price',
      'category',
      'created_at',
      'updated_at',
      'deleted_at',
      'logs_id',
      'wifi',
      'parking',
      'amenities',
      'tv',
      'gym'
    ];
    public function picture()
    {
        return $this->hasMany(Photo::class, 'venues_id');
    }
}
