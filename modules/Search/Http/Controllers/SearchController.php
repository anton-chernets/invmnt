<?php

namespace Modules\Search\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Article\Models\Article;
use Modules\Search\Http\Recourses\SearchResource;
use Modules\Search\Http\Requests\SearchRequest;
use Modules\Product\Models\Product;
use OpenApi\Annotations as OA;

class SearchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/search",
     *     summary="Display search results",
     *     tags={"Search"},
     *      @OA\Parameter(
     *          name="needle",
     *          description="for search",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="Uniswap",
     *          ),
     *      ),
     *     @OA\Response(
     *         description="Display search results",
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
     *                           "title": "Title",
     *                           "description": "Description",
     *                           "images": {
     *                                "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                           },
     *                           "details_uri": "articles/1",
     *                       }
     *                    )
     *             )
     *         )
     *     )
     * )
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function __invoke(SearchRequest $request): JsonResponse
    {
        $searchExpression = "%{$request->input('needle')}%";//TODO implement ElasticSearch
        return response()->json([
            'data' => SearchResource::collection(
                Article::where('title', 'LIKE', $searchExpression)
                    ->orWhere('description', 'LIKE', $searchExpression)
                    ->orderBy('created_at', 'desc')
                    ->get()->merge(
                        Product::where('title', 'LIKE', $searchExpression)
                            ->orWhere('description', 'LIKE', $searchExpression)
                            ->orderBy('created_at', 'desc')
                            ->get()
                    ),
            )
        ]);
    }
}
