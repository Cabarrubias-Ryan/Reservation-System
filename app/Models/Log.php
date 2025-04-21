<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  protected $table = 'activity_logs';
  protected $fillable = [
    'id',
    'users_id',
    'action',
    'tablename',
    'description',
    'ip_address',
    'created_at',
    'updated_at',
  ];
}
