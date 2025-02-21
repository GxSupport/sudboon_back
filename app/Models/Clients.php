<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    protected $table = 'clients_new';

    protected $fillable = [
        'name',
        'last_name',
        'patronymic',
        'passport',
        'pinfl',
        'date_of_birth',
    ];
}
