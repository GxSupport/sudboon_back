<?php

namespace App\Http\Integrations\Sud\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListCheck extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function __construct(public string $page, public string $size)
    {

    }
    public function resolveEndpoint(): string
    {
        return '/invoice/search?inn='.config('services.sud.inn').'&passportNumber=&page='.$this->page.'&size='.$this->size;
    }
}
