<?php

namespace Modules\File\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Article\Models\Article;
use Modules\File\Http\Requests\UploadRequest;
use Modules\Product\Models\Product;
use OpenApi\Annotations as OA;

class FileController extends Controller
{
    /**
     * @OA\Post(
     * tags={"Files"},
     * description="upload files for models",
     * path="/api/files/upload",
     * security={{"Authorization":{}}},
     * @OA\RequestBody(
     *            required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * type="object",
     *     @OA\Property(description="model id", property="id", type="integer", example=1),
     *     @OA\Property(description="model type", property="model", type="string", example="Article"),
     *     @OA\Property(
     *        description="file to upload",
     *        property="files",
     *        type="array",
     *    @OA\Items(
     *       type="string",
     *       format="binary",
     *    ),
     * )
     * )
     * )
     * ),
     *       @OA\Response(
     *            description="upload",
     *            response=200,
     *            @OA\JsonContent(
     *                @OA\Property(
     *                    property="success",
     *                    type="boolean",
     *                    example=true
     *                ),
     *            )
     *        ),
     *  @OA\Response(
     *  response=401,
     *  description="Unauthorized",
     *  ),
     *  @OA\Response(
     *  response=403,
     *  description="Forbidden"
     *  ),
     * )
     * @param UploadRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function upload(UploadRequest $request): JsonResponse
    {
        if (! $request->user()->isAdmin()) {
            return response()->json([
                'message' => 'this action only admin'
            ], 404);
        }

        $model = match ($request->get('model')) {
            'Article' => Article::where('id', $request->input('id')),
            'Product' => Product::where('id', $request->input('id')),
            default => throw new \Exception('undefined model type'),
        };

        /** @var Article|Product $object */
        $object = $model->first();
        foreach ($request->allFiles() as $file) {
            $object->addMedia($file)->toMediaCollection('images');
        }

        return response()->json(['success' => true]);
    }
}
