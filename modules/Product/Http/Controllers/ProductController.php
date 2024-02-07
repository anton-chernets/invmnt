<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Product\Http\Recourses\ProductResource;
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
     *                          "title": "Product",
     *                          "description": "Product description",
     *                          "category": "Product category",
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
}
