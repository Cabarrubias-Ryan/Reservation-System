<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherDetails extends Model
{
    protected $table = 'vouchers_details';

    protected $fillable = [
      'id',
      'start_at',
      'expired_at',
      'users_id',
      'vouchers_id',
      'use'
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'vouchers_id', 'id');
    }
}
