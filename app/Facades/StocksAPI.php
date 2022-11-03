<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class StocksAPI extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'stocks-api';
    }
}
