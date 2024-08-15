<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContracts extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'amount',
        'number',
        'contract_id',
        'payment_status',
        'is_active',
        'courtTypeId',
        'regionId',
        'courtRegionId',
        'purposeId',
        'payCategoryId'
    ];
}
