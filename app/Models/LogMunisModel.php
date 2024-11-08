<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMunisModel extends Model
{
    use HasFactory;
    protected $table = 'log_munis';

    protected $fillable = [
        'invoice',
        'stage',
        'status',
        'response'
    ];
}
