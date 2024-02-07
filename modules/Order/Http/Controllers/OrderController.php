<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Order\Http\Recourses\OrderResource;
use OpenApi\Annotations as OA;

class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Display orders",
     *     tags={"Order"},
     *     security={ {"Authorization":{}}},
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         description="Display orders",
     *         response=200,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                   property="data",
     *                   type="array",
     *                   title="orders",
     *                   @OA\Items(
     *                      type="object",
     *                      example={
     *                          "total_price": 1,
     *                          "created_at": "2024-02-03T16:53:20.000000Z",
     *                          "updated_at": "2024-02-03T16:53:20.000000Z",
     *                          "line_items": {
     *                              {
     *                                  "price": 111,
     *                                  "quantity": 1,
     *                                  "product_info": {
     *                                      {
     *                                          "title": "title product",
     *                                          "description": "description product",
     *                                          "images": {}
     *                                      }
     *                                  }
     *                              }
     *                          }
     *                      }
     *                   )
     *             )
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'data' => OrderResource::collection($request->user()->orders),
        ]);
    }
}
