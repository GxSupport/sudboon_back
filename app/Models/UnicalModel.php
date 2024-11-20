<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnicalModel extends Model
{
    protected $table = 'unicals';
    use HasFactory;


    protected $fillable = [
        'identifier',
        'contract',
        'invoice',
        'payment_status',
        'pay_status',
        'send_pdf'
    ];
}
