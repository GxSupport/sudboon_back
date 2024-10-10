<?php

namespace App\Http\Integrations\Payment\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class GetPaymentRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */

    public function __construct(protected int $invoice)
    {
    }

    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/api/invoice/checkStatus?invoice='.$this->invoice;
    }

    public function defaultBody(): array
    {
        return [
            'invoice' => (string)$this->invoice,
        ];
    }
}
