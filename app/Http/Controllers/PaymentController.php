<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Payment\Pay;
use App\Http\Integrations\Payment\Payment;
use App\Http\Integrations\Payment\Requests\CreatePaymentRequest;
use App\Http\Integrations\Payment\Requests\PayRequest;
use App\Jobs\PayConfirmJob;
use App\Jobs\PayJob;
use App\Models\LogPayModal;
use App\Models\PaymentModel;
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
            $payment->update([
                'status' => "1",
                'payment_number' => $response['invoice'],
                'response' => $response,
                'response_code' => $response['requestStatus']['code']
            ]);
//        PayJob::dispatch($response['invoice'], $payment_id);

        }
    }

    public function postPay($invoice, $payment_id): void
    {
        $request = new PayRequest($invoice, 'search');
        $res = (new Pay())->send($request);
        $response = json_decode($res->body(), true);
        if ($response['code']==0){
            PayConfirmJob::dispatch($invoice, $payment_id);
        }
    }
    public function postPayConfirm($invoice,$payment_id)
    {
        $request = new PayRequest($invoice, 'confirm');
        $res = (new Pay())->send($request);
        $response = json_decode($res->body(), true);
        if($response['content']['munis']['state']=='success'){
            $payment = PaymentModel::query()->find($payment_id);
            $payment->update([
                'is_payed' => "1",
            ]);
            LogPayModal::query()->create([
                'invoice' => $invoice,
                'status'=> 'success',
                'response' => $res->body(),
                'response_code' => $response['code']
            ]);
        }
    }
}
