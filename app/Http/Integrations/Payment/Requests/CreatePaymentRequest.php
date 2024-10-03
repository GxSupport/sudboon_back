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

    public function __construct(protected int $courtTypeId,
                                protected int    $regionId, protected int $courtRegionId,
                                protected int $payCategoryId, protected int $purposeId,
                                protected int $amount, protected array $client)
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
            'amount' => $this->amount *100,
            'courtId' => $this->courtTypeId,
            'courtType' => 'CITIZEN',
            'entityType' => 'JURIDICAL',
            'isInFavor' => true,
            'juridicalEntity' => [
                'address' => config('services.sud.address'),
                'name' => config('services.sud.company_name'),
                'tin' => config('services.sud.inn'),
            ],
            'overdue' => 0,
            'payCategoryId' => $this->payCategoryId,
            'purposeId' => $this->purposeId,
            'description' => $this->client['lastName'] . ' ' . $this->client['name'] . ' ' . $this->client['patronymic'],
        ];
    }
}
