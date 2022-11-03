<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'company_name' => $this->resource['companyName'],
            'symbol' => $this->resource['symbol'],
            'latest_price' => $this->resource['latestPrice']
        ];
    }
}
