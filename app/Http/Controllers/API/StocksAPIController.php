<?php

namespace App\Http\Controllers\API;

use App\Facades\StocksAPI;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;
use Illuminate\Http\Request;

class StocksAPIController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/stocks/{symbol}",
     *     tags={"Stocks API"},
     *     description="Search Stocks on API provider",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="symbol",
     *         in="path",
     *         description="Stocks name",
     *         required=true,
     *         @OA\Examples(example="string", value="nflx", summary="Netflix Stocks"),

     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(type="json")
     *             },
     *             @OA\Examples(example="json", value={"data": {"company_name": "Netflix Inc.","symbol": "NFLX", "latest_price": 273.08}}, summary="Sucess"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="error"
     *     ),
     * )
     */
    public function __invoke(Request $request, $symbol)
    {
        $stock = StocksAPI::get("stock/$symbol/quote")->json();

        if (!$stock) {
            return response()->json([
                'error' => 'Enter a valid stock name',
            ], 400);
        }
        return new StockResource($stock);
    }
}
