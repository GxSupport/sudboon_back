<?php

namespace App\Http\Integrations\Payment\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreatePaymentRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * The HTTP method of the request
     */

    public function __construct(protected string $company_name, protected int $tin,
                                protected string $address, protected int $courtTypeId,
                                protected int    $regionId, protected int $courtRegionId,
                                protected int $payCategoryId, protected int $purposeId,
                                protected int $amount)
    {
    }

    protected Method $method = Method::POST;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/api/invoice/create';
    }

    public function defaultBody(): array
    {
        return [
            'amount' => $this->amount,
            'courtId' => $this->courtTypeId,
            'courtType' => 'CITIZEN',
            'entityType' => 'JURIDICAL',
            'isInFavor' => true,
            'juridicalEntity' => [
                'address' => $this->address,
                'name' => $this->company_name,
                'tin' => $this->tin
            ],
            'overdue' => 0,
            'payCategoryId' => $this->payCategoryId,
            'purposeId' => $this->purposeId,
        ];
    }
}
