<?php

namespace App\Services;

use App\Models\LogPayModal;

/**
 * Class LogPayService
 * @package App\Services
 */
class LogPayService
{

    public static function getByInvoice(int $invoice)
    {
        return LogPayModal::query()->where('invoice',$invoice)->get();
    }
}
