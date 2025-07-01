<?php

namespace App\Http\Controllers\Api;

use App\Enums\TelegramBotActionsEnum;
use App\Http\Controllers\Controller;
use App\Jobs\Telegram\Numerology\ResponseTelegramUserJob;
use App\Jobs\UpdateOrCreateTelegramUserJob;
use App\Services\Telegram\TelegramBotTokenResolverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

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

        /* TODO refactor */
        $telegram = new Api(app(TelegramBotTokenResolverService::class)->token());
        $chatId = data_get($requestBody, 'message.chat.id')
            ?? data_get($requestBody, 'callback_query.message.chat.id');
        $telegram->sendChatAction([
            'chat_id' => $chatId,
            'action' => TelegramBotActionsEnum::Typing->value,
        ]);
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'думаю над запитом 🤔',
        ]);
        sleep(3);
        /* TODO refactor */

        ResponseTelegramUserJob::dispatch($requestBody);

        UpdateOrCreateTelegramUserJob::dispatch($requestBody);

        return response()->json(['status' => true]);
    }
}
