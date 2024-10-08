<?php

namespace App\Sevices\Client;

use App\Models\ClientContracts;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientContractService
{
    public static function createClientContract(
        $clientId,
        $amount,
        $number,
        $contractId,
        $is_active,
        $courtTypeId,

    )
    {
        return ClientContracts::query()->create([
            'client_id' => $clientId,
            'amount' => $amount,
            'number' => $number,
            'contract_id' => $contractId,
            'is_active' => $is_active,
            'courtTypeId' => $courtTypeId,


        ]);

    }
    public static function list($page,$perPage,$search): LengthAwarePaginator
    {
        $query = ClientContracts::query();
        if ($search){
            $query->where('number','like','%'.$search.'%');
        }
        return $query->paginate($perPage, ['*'], 'page', $page);

    }
    public static function checkById($id, $client_id): array|object|null
    {
        return ClientContracts::query()->where('contract_id',$id)->where('client_id',$client_id)->first();
    }

}
