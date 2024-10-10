<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Payment\Pay;
use App\Http\Integrations\Payment\Payment;
use App\Http\Integrations\Payment\Requests\CreatePaymentRequest;
use App\Http\Integrations\Payment\Requests\PayRequest;
use App\Jobs\PayConfirmJob;
use App\Jobs\PayJob;
use App\Jobs\PaySearchJob;
use App\Models\LogPayModal;
use App\Models\PaymentModel;
use App\Sevices\PaymentService;
use App\Sevices\UnicalService;
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
        }
    }

    public function callbackPayment(Request $request): void
    {
        $data = $request->all();
        PayJob::dispatch($data);
    }


    public function postPay($data)
    {
        foreach ($data as $item) {
            $check_unical = UnicalService::checkByUnical($item['id']);
            if ($check_unical){
                $payment = PaymentService::getPaymentInvoice($item['invoice']);
                if ($payment){
                    PaySearchJob::dispatch($item['invoice'], 'search');
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
        if($response['content']['munis']['state']=='success'){
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
        }

    }

    public function paySearch($invoice, $stage)
    {
        $request = new PayRequest($invoice, $stage);
        $res = (new Pay())->send($request);
        $response = json_decode($res->body(), true);
        if ($response['code']==0){
            $unical = UnicalService::getByUnicalInvoice($invoice);
            if ($unical){
                $unical->update([
                    'pay_status'=> 'waiting'
                ]);
            }
            PayConfirmJob::dispatch($invoice);
        }
    }
}
