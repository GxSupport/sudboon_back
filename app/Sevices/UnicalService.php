<?php

namespace App\Sevices;

use App\Models\UnicalModel;

class UnicalService
{

    public static function checkByUnical($id)
    {
        return UnicalModel::query()->where('identifier',$id)->first();
    }
    public static function createUnical($id,$contract)
    {
        return UnicalModel::query()->create([
            'identifier' => $id,
            'contract' => $contract,
        ]);
    }
    public static function getByUnicalContract($contract)
    {
        return UnicalModel::query()->where('contract',$contract)->first();
    }
    public static function getByUnicalInvoice($invoice)
    {
        return UnicalModel::query()->where('invoice',$invoice)->first();
    }


}
