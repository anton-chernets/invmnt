<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Product\Http\Recourses\ProductResource;
use Modules\Product\Http\Requests\ProductCreateRequest;
use Modules\Product\Http\Requests\ProductRemoveRequest;
use Modules\Product\Http\Requests\ProductUpdateRequest;
use Modules\Product\Http\Requests\SearchRequest;
use Modules\Product\Models\Product;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Display products",
     *     tags={"Product"},
     *     @OA\Parameter(
     *         name="page",
     *         description="for paginate",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *             example=1,
     *         ),
     *     ),
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
     *                          "id": 1,
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
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::where('stock', '>', 0)->paginate(10));
    }

    /**
     * @OA\Get(
     *     path="/api/products/search",
     *     summary="Display products",
     *     tags={"Product"},
     *      @OA\Parameter(
     *          name="needle",
     *          description="for search",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="Укр",
     *          ),
     *      ),
     *     @OA\Response(
     *         description="Display products",
     *         response=200,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                   property="data",
     *                   type="array",
     *                   title="products",
     *                    @OA\Items(
     *                       type="object",
     *                       example={
     *                           "id": 1,
     *                           "title": "Product Title",
     *                           "description": "Product description",
     *                           "stock": 111,
     *                           "price": 10.1,
     *                           "updated_at": "2024-02-03T16:53:20.000000Z",
     *                           "created_at": "2024-02-03T16:53:20.000000Z",
     *                           "images": {
     *                                "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                           },
     *                       }
     *                    )
     *             )
     *         )
     *     )
     * )
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function search(SearchRequest $request): JsonResponse
    {
        return response()->json([
            'data' => ProductResource::collection(
                Product::where('title','LIKE', "%{$request->input('needle')}%")
                    ->orWhere('description','LIKE', "%{$request->input('needle')}%")
                    ->orderBy('created_at', 'desc')
                    ->paginate()
            )
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/products/trashed",
     *     summary="Display trashed products",
     *     tags={"Product"},
     *     security={ {"Authorization":{}}},
     *     @OA\Response(
     *         description="Display trashed products",
     *         response=200,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                    property="data",
     *                    type="array",
     *                    title="products",
     *                    @OA\Items(
     *                       type="object",
     *                       example={
     *                           "id": 1,
     *                           "title": "Product Title",
     *                           "description": "Product description",
     *                           "stock": 111,
     *                           "price": 10.1,
     *                           "updated_at": "2024-02-03T16:53:20.000000Z",
     *                           "created_at": "2024-02-03T16:53:20.000000Z",
     *                           "images": {
     *                                "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                           },
     *                       }
     *                    )
     *              )
     *          )
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function trashed(): JsonResponse
    {
        return response()->json([
            'data' => ProductResource::collection(Product::onlyTrashed()->get())
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
     *                        "id": 1,
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
        return response()->json([
            'data' => ProductResource::make(
                Product::create($request->validated())
            )
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/products/show/{id}",
     *     summary="Get product",
     *     tags={"Product"},
     *     @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *            type="integer",
     *            example=1,
     *       ),
     *      ),
     *      @OA\Response(
     *          description="Get product",
     *          response=200,
     *          @OA\JsonContent(
     *               @OA\Property(
     *                    property="data",
     *                    type="object",
     *                    example={
     *                        "id": 1,
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
     * @param int $productId
     * @return JsonResponse
     * @throws Exception
     */
    public function show(int $productId): JsonResponse
    {
        return response()->json([
            'data' => ProductResource::make(
                Product::findOrFail($productId)
            )
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/products/update/{id}",
     *     summary="update product",
     *     tags={"Product"},
     *      security={ {"Authorization":{}}},
     *     @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *            type="integer",
     *            example=1,
     *       ),
     *      ),
     *       @OA\RequestBody(
     *            description="update product",
     *            required=true,
     *            @OA\JsonContent(
     *                 type="object",
     *                 example={
     *                    "title": "Product",
     *                    "description": "Product description",
     *                    "stock": 111,
     *                    "price": 10.1,
     *                 }
     *            )
     *       ),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(
     *          description="Get product",
     *          response=200,
     *          @OA\JsonContent(
     *               @OA\Property(
     *                    property="data",
     *                    type="object",
     *                    example={
     *                        "id": 1,
     *                        "title": "Product Title",
     *                        "description": "Product description",
     *                        "stock": 1,
     *                        "price": 10.1,
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
     * @param int $productId
     * @param ProductUpdateRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(int $productId, ProductUpdateRequest $request): JsonResponse
    {
        $product = Product::findOrFail($productId);

        $product->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        return response()->json([
            'data' => ProductResource::make($product)
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/remove",
     *     summary="remove current product",
     *     tags={"Product"},
     *     security={ {"Authorization":{}}},
     *     @OA\RequestBody(
     *        description="remove product",
     *        required=true,
     *        @OA\JsonContent(
     *            type="object",
     *            example={
     *               "id": 1,
     *           }
     *        )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         description="remove current product",
     *         response=200,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                   property="success",
     *                   type="boolean",
     *                   example=true
     *             )
     *         )
     *     )
     * )
     * @param ProductRemoveRequest $request
     * @return JsonResponse
     */
    public function remove(ProductRemoveRequest $request): JsonResponse
    {
        return response()->json([
            'success' => (bool) Product::where('id', $request->input('id'))->delete(),
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/products/restore",
     *     summary="restore current product",
     *     tags={"Product"},
     *     security={ {"Authorization":{}}},
     *     @OA\RequestBody(
     *        description="restore product",
     *        required=true,
     *        @OA\JsonContent(
     *            type="object",
     *            example={
     *               "id": 1,
     *           }
     *        )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         description="restore current product",
     *         response=200,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                   property="success",
     *                   type="boolean",
     *                   example=true
     *             )
     *         )
     *     )
     * )
     * @param ProductRemoveRequest $request
     * @return JsonResponse
     */
    public function restore(ProductRemoveRequest $request): JsonResponse
    {
        return response()->json([
            'success' => (bool) Product::where('id', $request->input('id'))->restore(),
        ]);
    }
}
