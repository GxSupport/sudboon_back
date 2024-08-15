<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Sud\Requests\GetCheck;
use App\Http\Integrations\Sud\Requests\ListCheck;
use App\Http\Integrations\Sud\Sud;
use App\Jobs\ContractJob;
use App\Sevices\CheckService;
use App\Sevices\Client\ClientContractService;
use App\Sevices\Client\ClientService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class ContractController extends Controller
{
    public function callbackContract(Request $request)
    {
        $data = $request->all();
        ContractJob::dispatch($data);
        return response()->json(['message' => 'success']);
    }
    public function addContractListFromJob($data):void
    {
        foreach ($data as $item) {

            $check = ClientService::checkByPassportOrPinfl($item['client']['passport'], $item['client']['pinfl']);
            if (!$check){
                $check = ClientService::createClient(
                    $item['client']['name'],
                    $item['client']['lastName'],
                    $item['client']['patronymic'],
                    $item['client']['passport'],
                    $item['client']['pinfl'],
                    $item['client']['dateBrith']
                );
            }
            ClientContractService::createClientContract(
                $check->id,
                $item['amount'],
                null,
                $item['id'],
                true,
                $item['courtTypeId'],
                $item['regionId'],
                $item['courtRegionId'],
                $item['purposeId'],
                $item['payCategoryId'],
            );
        }

    }
    public function getCheck($id)
    {

        $connection = new Sud();
        $request = new GetCheck($id);

        $response = $connection->send($request);
        $data=json_decode($response->body(), true);
        if ($data['requestStatus']['code']==200){
            $item = CheckService::checkByNumber($data['number']);
            if (!$item){
                $check = CheckService::createCheck($data);
            }else{
                $check = CheckService::updateCheck($data, $item);
            }
            return success(CheckService::checkByNumber($data['number']));
        }
        return error($data['requestStatus']['message']);
    }
    public function listCheck(Request $request)
    {
        $page = $request->get('page', 0);
        $per_page = $request->get('per_page', 10);

    $connection = new Sud();
    $request = new ListCheck($page, $per_page);
    $response = $connection->send($request);
    $data=json_decode($response->body(), true);
    if ($data['content']){
        foreach ($data['content'] as $item) {
            $check = CheckService::checkByNumber($item['number']);
            if (!$check){
                $check = CheckService::createCheck($item);
            }else{
                $check = CheckService::updateCheck($item, $check);
            }
        }
        return success($data['content']);
    }
        return error($data['requestStatus']['message']);

    }

}
