<?php


namespace App\Http\Integrations\OneC\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SendPdfTo1CRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;
    public function __construct(protected array $data)
    {
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/addimg';
    }
    public function defaultBody(): array
    {
        return [
            'invoice' => $this->data['invoice'],
            'contract' => $this->data['contract'],
            'data' => $this->data['data']
        ];
    }
}
