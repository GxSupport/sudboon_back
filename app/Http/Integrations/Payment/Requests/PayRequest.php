<?php

namespace App\Http\Integrations\Payment\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Repositories\Body\JsonBodyRepository;
use Saloon\Traits\Body\HasJsonBody;

class PayRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */

    public function __construct(public string $invoice, public string $stage)
    {
    }

    protected Method $method = Method::POST;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/ccenter/AAEx92e/krbcxDqZGri1OGDW5QEXKfajrT8/installment.php';
    }

    protected function defaultBody(): array
    {
        return [
            'apiId' => 19,
            'content' => [
                "method" => 'munis.pay',
                "params"=>[
                    "stage"=>$this->stage,
                    "invoice"=>$this->invoice,
                ]
            ]
        ];
    }
}
