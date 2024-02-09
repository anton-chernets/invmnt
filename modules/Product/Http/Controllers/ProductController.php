<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Product\Http\Recourses\ProductResource;
use Modules\Product\Http\Requests\ProductCreateRequest;
use Modules\Product\Models\Product;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Display products",
     *     tags={"Product"},
     *     @OA\Response(
     *         description="Display products",
     *         response=200,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                   property="data",
     *                   type="array",
     *                   title="products",
     *                   @OA\Items(
     *                      type="object",
     *                      example={
     *                          "title": "Product Title",
     *                          "description": "Product description",
     *                          "stock": 111,
     *                          "price": 10.1,
     *                          "updated_at": "2024-02-03T16:53:20.000000Z",
     *                          "created_at": "2024-02-03T16:53:20.000000Z",
     *                          "images": {
     *                               "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                          },
     *                      }
     *                   )
     *             )
     *         )
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => ProductResource::collection(Product::all()->where('stock', '>', 0))
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/products/store",
     *     summary="Create product",
     *     tags={"Product"},
     *      security={{"Authorization":{}}},
     *      @OA\RequestBody(
     *           description="create product",
     *           required=true,
     *           @OA\JsonContent(
     *                type="object",
     *                example={
     *                   "title": "Product",
     *                   "description": "Product description",
     *                   "stock": 111,
     *                   "price": 10.1,
     *                }
     *           )
     *      ),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(
     *          description="Create product",
     *          response=200,
     *          @OA\JsonContent(
     *               @OA\Property(
     *                    property="data",
     *                    type="object",
     *                    example={
     *                        "title": "Product Title",
     *                        "description": "Product description",
     *                        "updated_at": "2024-02-03T16:53:20.000000Z",
     *                        "created_at": "2024-02-03T16:53:20.000000Z",
     *                        "images": {
     *                           "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                        },
     *                    }
     *                 )
     *              )
     *          )
     *      )
     * )
     *
     * @param ProductCreateRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(ProductCreateRequest $request): JsonResponse
    {
        if (! $request->user()->isAdmin()) {
            return response()->json([
                'message' => 'this action only admin'
            ], 404);
        }

        return response()->json([
            'data' => ProductResource::make(
                Product::create($request->validated())
            )
        ]);
    }
}
