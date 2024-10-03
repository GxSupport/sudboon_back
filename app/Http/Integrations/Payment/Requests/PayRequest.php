<?php

namespace App\Http\Integrations\Payment\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PayRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */

    public function __construct(protected string $invoice)
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

    public function defaultBody(): array
    {
        return [
            'apiId' => config('services.munis.api_id'),
            'content' => [
                "method" => config('services.munis.method'),
                "params"=>[
                    "stage"=>"search",
                    "invoice"=>$this->invoice,
                ]
            ]
        ];
    }
}
