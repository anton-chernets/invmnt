<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Telegram\Numerology\ResponseTelegramUserJob;
use App\Jobs\UpdateOrCreateTelegramUserJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/telegram/webhook",
     *     summary="Handle Telegram webhook",
     *     tags={"Telegram"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="object",
     *                 @OA\Property(
     *                     property="from",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=11111111),
     *                     @OA\Property(property="first_name", type="string", example="Anton"),
     *                 ),
     *                 @OA\Property(property="text", type="string", example="/start"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Webhook handled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     )
     * )
     * @throws \Exception
     */
    public function handle(Request $request): JsonResponse
    {
        $requestBody = $request->all();

        logs()->info('Telegram webhook request', $requestBody);

        ResponseTelegramUserJob::dispatch($requestBody);

        UpdateOrCreateTelegramUserJob::dispatch($requestBody);

        return response()->json(['status' => true]);
    }
}
