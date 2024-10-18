<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Payment\Pay;
use App\Http\Integrations\Payment\Payment;
use App\Http\Integrations\Payment\PaymentResponse;
use App\Http\Integrations\Payment\PayResponse;
use App\Http\Integrations\Payment\Requests\CreatePaymentRequest;
use App\Http\Integrations\Payment\Requests\GetPaymentRequest;
use App\Http\Integrations\Payment\Requests\PaymentResponseRequest;
use App\Http\Integrations\Payment\Requests\PayRequest;
use App\Http\Integrations\Payment\Requests\PayResponseRequest;
use App\Jobs\PayConfirmJob;
use App\Jobs\PayJob;
use App\Jobs\PaymentResponseJob;
use App\Jobs\PayResponseJob;
use App\Jobs\PaySearchJob;
use App\Models\LogPayModal;
use App\Models\PaymentModel;
use App\Models\PayResponseOneCModel;
use App\Sevices\Client\ClientService;
use App\Sevices\PaymentService;
use App\Sevices\UnicalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class PaymentController extends Controller
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function createPayment($item, $payment_id): void
    {
        $request = new CreatePaymentRequest(
            $item['courtTypeId'],
            $item['payCategoryId'] ?? 3,
            $item['purposeId']?? 8,
            18750,
            $item['client']
        );
        $res = (new Payment())->send($request);
        $response = json_decode($res->body(), true);
        if ($response['requestStatus']['code']==200) {
            $payment = PaymentModel::query()->find($payment_id);
            $unical = UnicalService::getByUnicalContract($item['contract']);
            if ($unical){
                $unical->update([
                    'invoice' => $response['invoice'],
                    'payment_status' => 'created'
                ]);
            }
            $payment->update([
                'status' => "1",
                'payment_number' => $response['invoice'],
                'response' => $response,
                'response_code' => $response['requestStatus']['code']
            ]);
            PaymentResponseJob::dispatch($response['invoice']);
        }
    }

    public function callbackPayment(Request $request): JsonResponse
    {
        $data = $request->all();
        PayJob::dispatch($data);
        return response()->json(['message' => 'success']);
    }


    public function postPay($data)
    {
        foreach ($data as $item) {
            $check_unical = UnicalService::checkByUnical($item['id']);
            if ($check_unical){
                if ($check_unical->pay_status=='paid'){
                    PayResponseJob::dispatch($item['invoice'], 'paid');
                }else {
                    $payment = PaymentService::getPaymentInvoice($item['invoice']);
                    if ($payment) {
                        PaySearchJob::dispatch($item['invoice'], 'search');
                    }
                }
            }
        }
    }
    public function postPayConfirm($invoice)
    {
        $unical = UnicalService::getByUnicalInvoice($invoice);
        $request = new PayRequest($invoice, 'confirm');
        $res = (new Pay())->send($request);
        $response = json_decode($res->body(), true);
        if(isset($response['content']['munis']['state'])){
            if ($response['content']['munis']['state']=='success'){
                $payment = PaymentService::getPaymentInvoice($invoice);
                $unical?->update([
                    'pay_status' => 'paid'
                ]);
                $payment->update([
                    'is_payed' => "1",
                ]);
                LogPayModal::query()->create([
                    'invoice' => $invoice,
                    'status'=> 'success',
                    'response' => $res->body(),
                    'response_code' => $response['code']
                ]);
                PayResponseJob::dispatch($invoice, 'paid');
            }
        }else{
            LogPayModal::query()->create([
                'invoice' => $invoice,
                'status'=> 'failed',
                'response' => $res->body(),
                'response_code' => $response['code']
            ]);
            $unical?->update([
                'pay_status'=> 'failed'
            ]);
            PayResponseJob::dispatch($invoice, 'failed');
        }
    }

    public function paySearch($invoice, $stage)
    {
        $request = new PayRequest($invoice, $stage);
        $res = (new Pay())->send($request);
        $response = json_decode($res->body(), true);
        if ($response['code']==0){
            $unical = UnicalService::getByUnicalInvoice($invoice);
            $unical?->update([
                'pay_status' => 'waiting'
            ]);
            PayConfirmJob::dispatch($invoice);
        }
        if ($response['code']=='101'){
            $unical = UnicalService::getByUnicalInvoice($invoice);
            $payment = PaymentService::getPaymentInvoice($invoice);
            $payment->update([
                'is_payed' => "1",
            ]);
            $unical?->update([
                'pay_status' => 'paid'
            ]);
            PayResponseJob::dispatch($invoice, 'paid');
        }
    }

    public function onecResponsePayment($invoice)
    {
        $unical = UnicalService::getByUnicalInvoice($invoice);
        $payment = PaymentService::getPaymentInvoice($invoice);
        $client = ClientService::getClientByContractId($payment->contract_id);

        $requestCheck  = new GetPaymentRequest($invoice);
        $resCheck = (new Payment())->send($requestCheck);
        $responseCheck = json_decode($resCheck->body(), true);
        if ($responseCheck['requestStatus']['code']==200){
            $status = $responseCheck['invoiceStatus'];
            $issued = date('d.m.Y',$responseCheck['issued']/1000 );
            $overdue = date('d.m.Y',$responseCheck['overdue']/1000 );
            $pinfl = $client->pinfl;
            $name = $client->name;
            $last_name = $client->last_name;
            $patronymic = $client->patronymic;
            $contract = $unical->contract;
            $id = $unical->identifier;
            $request = new PaymentResponseRequest(
                $invoice,
                $status,
                $issued,
                $overdue,
                $pinfl,
                $name,
                $last_name,
                $patronymic,
                $contract,
                $id
            );
            $res = (new PaymentResponse)->send($request);
            $response = json_decode($res->body(), true);
        }
    }
    public function oneCResponsePay($invoice, $status)
    {
        $unical = UnicalService::getByUnicalInvoice($invoice);
//        $payment = PaymentService::getPaymentInvoice($invoice);
//        $client = ClientService::getClientByContractId($payment->contract_id);
        $issued = now()->format('d.m.Y');
//        $pinfl = $client->pinfl;
        $contract = $unical->contract;
        $id = $unical->identifier;
        $request = new PayResponseRequest(
            $invoice,
            $status,
            $issued,
//            $pinfl,
            $contract,
            $id
        );
        $res = (new PayResponse())->send($request);
        $response = json_decode($res->body(), true);

        PayResponseOneCModel::query()->create([
            'invoice' => $invoice,
            'response' => $res,
            'identifier' => $id,
        ]);

    }
    public function getPayment()
    {
        return now()->format('d.m.Y');

    }
}
