<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnicalModel extends Model
{
    protected $table = 'unicals';
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'identifier',
        'contract',
        'invoice',
        'payment_status',
        'pay_status',
        'send_pdf'
    ];
}
