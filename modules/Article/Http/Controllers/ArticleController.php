<?php

namespace Modules\Article\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Article\Http\Recourses\ArticleResource;
use Modules\Article\Http\Requests\ArticleCreateRequest;
use Modules\Article\Http\Requests\ArticleRemoveRequest;
use Modules\Article\Http\Requests\ArticleUpdateRequest;
use Modules\Article\Http\Requests\SearchRequest;
use Modules\Article\Models\Article;
use OpenApi\Annotations as OA;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="Display articles",
     *     tags={"Article"},
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
     *                          "title": "Article Title",
     *                          "alias": "article-title",
     *                          "author": "Parikshit Mishra",
     *                          "publish_date": "2024-03-11 07:24:27",
     *                          "description": "Article description",
     *                          "created_at": "2024-02-03T16:53:20.000000Z",
     *                          "updated_at": "2024-02-03T16:53:20.000000Z",
     *                          "images": {
     *                              "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                          },
     *                      }
     *                   )
     *             )
     *         )
     *     )
     * )
     *
     */
    public function index(): AnonymousResourceCollection
    {
        return ArticleResource::collection(
            Article::orderBy('publish_date', 'desc')->orderBy('created_at', 'desc')->paginate(10)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/articles/search",
     *     summary="Display articles",
     *     tags={"Article"},
     *      @OA\Parameter(
     *          name="needle",
     *          description="for search",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              example="Bitcoin",
     *          ),
     *      ),
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
     *                          "title": "Article Title",
     *                          "alias": "article-title",
     *                          "author": "Parikshit Mishra",
     *                          "publish_date": "2024-03-11 07:24:27",
     *                          "description": "Article description",
     *                          "created_at": "2024-02-03T16:53:20.000000Z",
     *                          "updated_at": "2024-02-03T16:53:20.000000Z",
     *                          "images": {
     *                              "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                          },
     *                      }
     *                   )
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
            'data' => ArticleResource::collection(
                Article::where('title','LIKE', "%{$request->input('needle')}%")
                    ->orWhere('description','LIKE', "%{$request->input('needle')}%")
                    ->orderBy('created_at', 'desc')
                    ->paginate()
            )
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/articles/trashed",
     *     summary="Display trashed articles",
     *     tags={"Article"},
     *     security={ {"Authorization":{}}},
     *     @OA\Response(
     *         description="Display trashed articles",
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
     *                          "title": "Article Title",
     *                          "alias": "article-title",
     *                          "author": "Parikshit Mishra",
     *                          "publish_date": "2024-03-11 07:24:27",
     *                          "description": "Article description",
     *                          "created_at": "2024-02-03T16:53:20.000000Z",
     *                          "updated_at": "2024-02-03T16:53:20.000000Z",
     *                          "images": {
     *                              "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
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
    public function trashed(): JsonResponse
    {
        return response()->json([
            'data' => ArticleResource::collection(Article::onlyTrashed()->get())
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/articles/store",
     *     summary="Create article",
     *     tags={"Article"},
     *      security={{"Authorization":{}}},
     *      @OA\RequestBody(
     *           description="create article",
     *           required=true,
     *           @OA\JsonContent(
     *                type="object",
     *                example={
     *                   "title": "Article Title",
     *                   "description": "Article description",
     *                }
     *           )
     *      ),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(
     *          description="Create article",
     *          response=200,
     *          @OA\JsonContent(
     *                @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     example={
     *                         "id": 1,
     *                         "title": "Article Title",
     *                         "alias": "article-title",
     *                         "author": "Parikshit Mishra",
     *                         "publish_date": "2024-03-11 07:24:27",
     *                         "description": "Article description",
     *                         "updated_at": "2024-02-03T16:53:20.000000Z",
     *                         "created_at": "2024-02-03T16:53:20.000000Z",
     *                         "images": {
     *                            "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                         },
     *                     }
     *                  )
     *
     *          )
     *      )
     * )
     *
     * @param ArticleCreateRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(ArticleCreateRequest $request): JsonResponse
    {
        return response()->json([
            'data' => ArticleResource::make(
                Article::create($request->validated())
            )
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/articles/remove",
     *     summary="remove current article",
     *     tags={"Article"},
     *     security={ {"Authorization":{}}},
     *     @OA\RequestBody(
     *        description="remove article",
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
     *         description="remove current article",
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
     * @param ArticleRemoveRequest $request
     * @return JsonResponse
     */
    public function remove(ArticleRemoveRequest $request): JsonResponse
    {
        return response()->json([
            'success' => (bool) Article::where('id', $request->input('id'))->delete(),
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/articles/restore",
     *     summary="restore current article",
     *     tags={"Article"},
     *     security={ {"Authorization":{}}},
     *     @OA\RequestBody(
     *        description="restore article",
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
     *         description="restore current article",
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
     * @param ArticleRemoveRequest $request
     * @return JsonResponse
     */
    public function restore(ArticleRemoveRequest $request): JsonResponse
    {
        return response()->json([
            'success' => (bool) Article::where('id', $request->input('id'))->restore(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/articles/show/{id}",
     *     summary="Get article",
     *     tags={"Article"},
     *     @OA\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *            type="string",
     *            example=1,
     *       ),
     *      ),
     *      @OA\Response(
     *          description="Get article",
     *          response=200,
     *          @OA\JsonContent(
     *                 @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      example={
     *                          "title": "Article Title",
     *                          "alias": "article-title",
     *                          "author": "Parikshit Mishra",
     *                          "publish_date": "2024-03-11 07:24:27",
     *                          "description": "Article description",
     *                          "updated_at": "2024-02-03T16:53:20.000000Z",
     *                          "created_at": "2024-02-03T16:53:20.000000Z",
     *                          "images": {
     *                             "https://gssc.esa.int/navipedia/images/a/a9/Example.jpg"
     *                          },
     *                      }
     *                   )
     *          )
     *      )
     * )
     *
     * @param string|int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string|int $id): JsonResponse
    {
        if ($object = Article::whereAlias($id)->first()) {
            //
        } else {
            $object = Article::findOrFail($id);
        }
        return response()->json([
            'data' => ArticleResource::make(
                $object
            )
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/articles/update/{id}",
     *     summary="update article",
     *     tags={"Article"},
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
     *            description="update article",
     *            required=true,
     *            @OA\JsonContent(
     *                 type="object",
     *                 example={
     *                    "title": "Article",
     *                    "description": "Article description",
     *                    "author": "author",
     *                 }
     *            )
     *       ),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(
     *          description="Update article",
     *          response=200,
     *          @OA\JsonContent(
     *               @OA\Property(
     *                    property="data",
     *                    type="object",
     *                    example={
     *                        "id": 1,
     *                        "title": "Article Title",
     *                        "alias": "article-title",
     *                        "author": "Parikshit Mishra",
     *                        "publish_date": "2024-03-11 07:24:27",
     *                        "description": "Article description",
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
     * @param int $id
     * @param ArticleUpdateRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(int $id, ArticleUpdateRequest $request): JsonResponse
    {
        $article = Article::findOrFail($id);

        $article->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'author' => $request->input('author'),
        ]);

        return response()->json([
            'data' => ArticleResource::make($article)
        ]);
    }
}
