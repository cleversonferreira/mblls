<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class StocksAPIProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('stocks-api', function () {
            return Http::withOptions([
                'debug' => false,
                'verify' => false,
                'base_uri' => env('STOCKS_API_URL'),
                'query' => [
                    'token' => env('STOCKS_API_TOKEN')
                ]
            ]);
        });
    }
}
