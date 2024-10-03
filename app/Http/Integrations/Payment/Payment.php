<?php

namespace App\Http\Integrations\Payment;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class Payment extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://billing.sud.uz';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
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
