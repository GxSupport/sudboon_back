<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayResponseOneCModel extends Model
{

    protected $table = 'pay_response_onec';
    use HasFactory;
    protected $fillable = [
        'invoice',
        'response',
        'identifier',
        'request'
    ];
}
