<?php

namespace App\Http\Integrations\Payment;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class PayResponse extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return config('services.onec.url');
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        $username = config('services.onec.user');
        $password = config('services.onec.password');
        $basicAuth = base64_encode("{$username}:{$password}");
        return [
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization'=> "Basic {$basicAuth}",

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
