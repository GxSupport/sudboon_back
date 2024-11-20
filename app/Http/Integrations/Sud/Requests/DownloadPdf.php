<?php


namespace App\Http\Integrations\Sud\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DownloadPdf extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;
    public function __construct(public string $invoice_id)
    {

    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/invoice/asDocument?invoice='.$this->invoice_id;
    }
}
