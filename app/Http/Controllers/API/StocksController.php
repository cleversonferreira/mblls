<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StockRequest;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class StocksController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/stocks/",
     *     tags={"Stocks"},
     *     description="Search Stocks on API provider",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="symbol",
     *         in="query",
     *         description="Stocks name",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="error"
     *     ),
     * )
     */
    public function index()
    {
        try {
            $stocks = Stock::where('user_id', Auth::user()->id)->get()->toArray();
            return $this->sendResponse($stocks, 'Recents stocks search by user');
        } catch (\Exception $e) {
            return $this->sendError($e, 'Error on create stock search history');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/stocks/",
     *     tags={"Stocks"},
     *     description="Search Stocks on API provider",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="symbol",
     *         in="query",
     *         description="Stocks name",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="error"
     *     ),
     * )
     */
    public function store(StockRequest $request)
    {
        try {
            $stocks = new Stock([
                'user_id' => Auth::user()->id,
                'company_name' => $request->input('company_name'),
                'symbol' => $request->input('symbol'),
                'latest_price' => $request->input('latest_price')
            ]);

            $stocks->save();
            return $this->sendResponse($stocks, 'Stocks created!');
        } catch (\Exception $e) {
            return $this->sendError($e, 'Error on create stock search history');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/stocks/",
     *     tags={"Stocks"},
     *     description="Search Stocks on API provider",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="symbol",
     *         in="query",
     *         description="Stocks name",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="error"
     *     ),
     * )
     */
    public function destroy($id)
    {
        try {
            $stocks = Stock::find($id);
            $stocks->delete();
            return $this->sendResponse($stocks, 'Stocks deleted!');
        } catch (\Exception $e) {
            return $this->sendError($e, 'Error on delete stock search history');
        }
    }
}
