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
     *     description="Get Searches history by user",
     *     security={{ "apiAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(type="json")
     *             },
     *             @OA\Examples(example="json", value={"success": true, "data": {"id": 16,"user_id": 1,"company_name": "Netflix","symbol": "nflx","latest_price": "143.90","created_at": "2022-11-03T17:47:03.000000Z","updated_at": "2022-11-03T17:47:03.000000Z"}, "message": "Recent searches"}, summary="Sucess"),
     *         )
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
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="company_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="symbol",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="latest_price",
     *                     type="integer"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(type="json")
     *             },
     *             @OA\Examples(example="json", value={"success": true, "data": {"id": 16,"user_id": 1,"company_name": "Netflix","symbol": "nflx","latest_price": "143.90","created_at": "2022-11-03T17:47:03.000000Z","updated_at": "2022-11-03T17:47:03.000000Z"}, "message": "Stocks history created"}, summary="Sucess"),
     *         ),
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
     *     path="/api/stocks/{id}",
     *     tags={"Stocks"},
     *     description="Remove stocks search from history",
     *     security={{ "apiAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Stocks id",
     *         required=true,
     *         @OA\Examples(example="integer", value="1", summary="Stocks id"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(type="json")
     *             },
     *             @OA\Examples(example="json", value={"success": true, "data": {"id": 16,"user_id": 1,"company_name": "Netflix","symbol": "nflx","latest_price": "143.90","created_at": "2022-11-03T17:47:03.000000Z","updated_at": "2022-11-03T17:47:03.000000Z"}, "message": "Stocks history deleted"}, summary="Sucess"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
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
