<?php

namespace App\Services;

use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class SearchHistoryService
{

    public function run($stock)
    {

        try
        {
            $stock_history = new Stock();
            $stock_history->user_id = Auth::user()->id;
            $stock_history->company_name = $stock['companyName'];
            $stock_history->symbol = $stock['symbol'];
            $stock_history->latest_price = $stock['latestPrice'];
            $stock_history->save();

            return true;

        } catch (\Exception $e) {
            Throw new \Exception($e->getMessage());
        }

    }

}
