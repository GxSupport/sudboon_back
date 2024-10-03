<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPayModal extends Model
{
    protected $table = 'log_pay';
    use HasFactory;

    protected $fillable = [
        'invoice',
        'status',
        'response',
        'response_code',
    ];
}
