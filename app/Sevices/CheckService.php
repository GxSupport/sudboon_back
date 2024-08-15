<?php

namespace App\Sevices;

use App\Models\Check;

class CheckService
{
    public static function checkByNumber($number)
    {
        return Check::where('number', $number)->first();
    }

    public static function updateCheck($data,$item)
    {
        return $item->update([
            'invoiceStatus'=>$data['invoiceStatus'],
            'paidAmount'=>$data['paidAmount'],
            'mustPayAmount'=>$data['mustPayAmount'],
            'number'=>$data['number'],
            'overdue'=>$data['overdue'],
            'payCategory'=>$data['payCategory'],
            'payCategoryId'=>$data['payCategoryId'],
            'court'=>$data['court'],
            'courtId'=>$data['courtId'],
            'courtOwnId'=>$data['courtOwnId'],
            'forAccount'=>$data['forAccount'],
            'amount'=>$data['amount'],
            'claimCaseNumber'=>$data['claimCaseNumber'],
            'decisionDate'=>$data['decisionDate'],
            'payer'=>$data['payer'],
            'payerId'=>$data['payerId'],
            'payerTin'=>$data['payerTin'],
            'payerPassport'=>$data['payerPassport'],
            'description'=>$data['description'],
            'isInFavor'=>$data['isInFavor'],
            'instance'=>$data['instance'],
            'purpose'=>$data['purpose'],
            'purposeId'=>$data['purposeId'],
            'issued'=>$data['issued'],
            'courtType'=>$data['courtType'],
            'balance'=>$data['balance'],
        ]);

    }
    public static function createCheck($data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return Check::query()->create([
            'invoiceStatus'=>$data['invoiceStatus'],
            'paidAmount'=>$data['paidAmount'],
            'mustPayAmount'=>$data['mustPayAmount'],
            'number'=>$data['number'],
            'overdue'=>$data['overdue'],
            'payCategory'=>$data['payCategory'],
            'payCategoryId'=>$data['payCategoryId'],
            'court'=>$data['court'],
            'courtId'=>$data['courtId'],
            'courtOwnId'=>$data['courtOwnId'],
            'forAccount'=>$data['forAccount'],
            'amount'=>$data['amount'],
            'claimCaseNumber'=>$data['claimCaseNumber'],
            'decisionDate'=>$data['decisionDate'],
            'payer'=>$data['payer'],
            'payerId'=>$data['payerId'],
            'payerTin'=>$data['payerTin'],
            'payerPassport'=>$data['payerPassport'],
            'description'=>$data['description'],
            'isInFavor'=>$data['isInFavor'],
            'instance'=>$data['instance'],
            'purpose'=>$data['purpose'],
            'purposeId'=>$data['purposeId'],
            'issued'=>$data['issued'],
            'courtType'=>$data['courtType'],
            'balance'=>$data['balance'],
        ]);
    }
}
