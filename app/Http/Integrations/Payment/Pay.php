<?php

namespace App\Http\Integrations\Payment;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class Pay extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://wi.ipakyulibank.uz';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
            'x-api-key' => config('services.ipakyulibank.api_key'),
        ];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [
            'timeout' => 30,
            'connect_timeout' => 10,
        ];
    }
}
