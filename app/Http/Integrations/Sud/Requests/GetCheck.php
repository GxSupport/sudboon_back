<?php

namespace App\Http\Integrations\Sud\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCheck extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;
    public function __construct(public string $id)
    {

    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
//        dd('invoice/checkStatus?lang=ruName&invoiceId='.$this->id);
        return '/invoice/checkStatus?invoice='.$this->id.'&lang=ruName';
    }
}
