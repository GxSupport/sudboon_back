<?php

namespace App\Sevices;

use App\Models\PaymentModel;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

class PaymentService
{
    public static function createPayment($item, $contract) : Builder|Model
    {
        return PaymentModel::query()->create([
            'contract_id'=>$contract->id,
            'amount'=>$item['amount'],
        ]);
    }

}
