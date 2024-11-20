<?php

namespace App\Services;

use App\Models\PayResponseOneCModel;

/**
 * Class PayResponseOneCService
 * @package App\Services
 */
class PayResponseOneCService
{

    public static function getByInvoice(int $invoice)
    {
        return PayResponseOneCModel::query()->where('invoice',$invoice)->get();
    }
}
