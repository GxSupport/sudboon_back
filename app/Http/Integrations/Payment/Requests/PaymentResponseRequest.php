<?php

namespace App\Http\Integrations\Payment\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PaymentResponseRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */

    public function __construct(
        protected int $invoice,
        protected string $status,
        protected string $issued,
        protected string $overdue,
        protected string $pinfl,
        protected string $name,
        protected string $last_name,
        protected string $patronymic,
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
        return 'sudinvoice';
    }

    public function defaultBody(): array
    {
        return [
            'invoice' => $this->invoice,
            'status' => $this->status,
            'issued' => $this->issued,
            'overdue' => $this->overdue,
            'pinfl' => $this->pinfl,
            'name' => $this->name,
            'lastName' => $this->last_name,
            'patronymic' => $this->patronymic,
            'contract' => $this->contract,
            'id' => $this->id,

        ];
    }
}
