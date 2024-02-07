<?php

namespace Modules\Article\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Article\Http\Recourses\ArticleResource;
use Modules\Article\Models\Article;
use OpenApi\Annotations as OA;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="Display articles",
     *     tags={"Article"},
     *     @OA\Response(
     *         description="Display articles",
     *         response=200,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                   property="data",
     *                   type="array",
     *                   title="articles",
     *                   @OA\Items(
     *                      type="object",
     *                      example={
     *                          "id": 1,
     *                          "title": "Article",
     *                          "description": "Article description",
     *                          "created_at": "2024-02-03T16:53:20.000000Z",
     *                          "updated_at": "2024-02-03T16:53:20.000000Z",
     *                          "images": {},
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
            'data' => ArticleResource::collection(Article::all())
        ]);
    }
}
