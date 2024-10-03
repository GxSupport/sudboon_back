<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Payment\Payment;
use App\Http\Integrations\Payment\Requests\CreatePaymentRequest;
use App\Http\Integrations\Sud\Requests\GetCheck;
use App\Http\Integrations\Sud\Requests\ListCheck;
use App\Http\Integrations\Sud\Sud;
use App\Http\Requests\PayedRequest;
use App\Jobs\ContractJob;
use App\Sevices\CheckService;
use App\Sevices\Client\ClientContractService;
use App\Sevices\Client\ClientService;
use App\Sevices\PaymentService;
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
            $contract = ClientContractService::checkById($item['id'], $check->id);

            if (!$contract){
                $contract =  ClientContractService::createClientContract(
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
            $payment = PaymentService::createPayment(
                $item,
                $contract
            );
            $request = new CreatePaymentRequest(
                config('services.sud.company_name'),
                config('services.sud.inn'),
                config('services.sud.address'),
                $item['courtTypeId'],
                $item['regionId'],
                $item['courtRegionId'],
                $item['payCategoryId'],
                $item['purposeId'],
                17000
            );
            $res = (new Payment())->send($request);
            $response = json_decode($res->body(), true);
            if ($response['requestStatus']['code']==200) {
                $payment->update([
                    'status' => 1,
                    'payment_number' => $response['invoice'],
                    'response' => $response,
                    'response_code' => $response['requestStatus']['code']
                ]);
            }
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
    public function list(Request $request)
    {
        $page = $request->get('page', 0);
        $per_page = $request->get('per_page', 10);
        $search = $request->get('search', null);


        return success(ClientContractService::list($page, $per_page,$search));

    }
    public function payed(PayedRequest $request): void
    {

        dd($request);

//        return success();

    }

}
