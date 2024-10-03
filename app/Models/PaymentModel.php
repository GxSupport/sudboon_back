<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'amount',
    ];
}
