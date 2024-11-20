<?php

namespace App\Services;

use App\Models\LogMunisModel;

/**
 * Class LogMunisService
 * @package App\Services
 */
class LogMunisService
{

    public static function getByInvoice(int $invoice)
    {
        return LogMunisModel::query()->where('invoice',$invoice)->get();
    }
}
