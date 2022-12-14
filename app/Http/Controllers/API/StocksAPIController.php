<?php

namespace App\Http\Controllers\API;

use App\Facades\StocksAPI;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;
use Illuminate\Http\Request;
use App\Services\SearchHistoryService;

class StocksAPIController extends Controller
{
    protected $searchHistoryService;

    public function __construct(SearchHistoryService $searchHistoryService)
    {
        $this->searchHistoryService = $searchHistoryService;
    }

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
     *         description="OK",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(type="json")
     *             },
     *             @OA\Examples(example="json", value={"data": {"company_name": "Netflix Inc.","symbol": "NFLX", "latest_price": 273.08}}, summary="Sucess"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(type="json")
     *             },
     *             @OA\Examples(example="json", value={"error": "Enter a valid stock name"}, summary="Error"),
     *         )
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

        $this->searchHistoryService->run($stock);

        return new StockResource($stock);
    }
}
