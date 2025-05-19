<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
      'id',
      'code',
      'name',
      'description',
      'requirements',
      'discount',
      'use',
      'expire_date',
      'created_at',
      'updated_at',
      'deleted_at'
    ];

    public function details()
    {
        return $this->hasMany(VoucherDetails::class, 'vouchers_id', 'id');
    }
}
