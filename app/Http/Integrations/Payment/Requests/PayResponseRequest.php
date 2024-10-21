<?php

namespace App\Http\Integrations\Payment\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PayResponseRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */

    public function __construct(
        protected int $invoice,
        protected string $status,
        protected string $issued,
        protected int $pinfl,
        protected string $contract,
        protected string $id,

    )
    {
    }

    protected Method $method = Method::POST;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return 'sudpay';
    }

    public function defaultBody(): array
    {
        return [
            'invoice' => $this->invoice,
            'status' => $this->status,
            'issued' => $this->issued,
            'pinfl' => $this->pinfl,
            'contract' => $this->contract,
            'id' => $this->id,

        ];
    }
}
