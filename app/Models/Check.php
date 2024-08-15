<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $table = 'check';
    use HasFactory;
    protected $fillable = [
        'invoiceStatus', // Add this line
        'paidAmount',
        'mustPayAmount',
        'number',
        'overdue',
        'payCategory',
        'payCategoryId',
        'court',
        'courtId',
        'courtOwnId',
        'forAccount',
        'amount',
        'claimCaseNumber',
        'decisionDate',
        'payer',
        'payerId',
        'payerTin',
        'payerPassport',
        'description',
        'isInFavor',
        'instance',
        'purpose',
        'purposeId',
        'issued',
        'courtType',
        'balance',
    ];
}
