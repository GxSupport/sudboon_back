<?php

namespace App\Sevices\Client;

use App\Models\Clients;

class ClientService
{
    public static function checkByPassportOrPinfl($passport, $pinfl)
    {
        $item = Clients::where('passport', $passport)->orWhere('pinfl', $pinfl)->first();
        return $item;
    }

    public static function createClient(
        $name,
        $last_name,
        $patronymic,
        $passport,
        $pinfl,
        $dateBrith

    )
    {
       return Clients::query()->create([
            'name' => $name,
            'last_name' => $last_name,
            'patronymic' => $patronymic,
            'passport' => $passport,
            'pinfl' => $pinfl,
            'date_of_birth' => $dateBrith,
        ]);

    }

    public static function getClientByContractId($contract_id)
    {
        $client_contract = ClientContractService::getBytId($contract_id);
        $client_id = $client_contract->client_id;
        dd($client_id);
        return Clients::query()->find($client_contract->client_id);



    }

}
