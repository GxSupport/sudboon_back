<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'patronymic',
        'passport',
        'pinfl',
        'date_of_birth',
    ];
}
