<?php

namespace App\Sevices\Client;

use App\Models\ClientContracts;

class ClientContractService
{
    public static function createClientContract(
        $clientId,
        $amount,
        $number,
        $contractId,
        $is_active,
        $courtTypeId,
        $regionId,
        $courtRegionId,
        $purposeId,
        $payCategoryId
    )
    {
        return ClientContracts::query()->create([
            'client_id' => $clientId,
            'amount' => $amount,
            'number' => $number,
            'contract_id' => $contractId,
            'is_active' => $is_active,
            'courtTypeId' => $courtTypeId,
            'regionId' => $regionId,
            'courtRegionId' => $courtRegionId,
            'purposeId' => $purposeId,
            'payCategoryId' => $payCategoryId,
        ]);

    }

}
