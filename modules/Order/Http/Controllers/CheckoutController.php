<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\JsonResponse;
use Modules\Order\Events\OrderFulfilled;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\UserDto;
use OpenApi\Annotations as OA;

class CheckoutController extends Controller
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected DatabaseManager $databaseManager,
        protected Dispatcher $events,
    ) {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/checkout",
     *     summary="create order.",
     *     tags={"Checkout"},
     *     security={ {"Authorization":{}}},
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\RequestBody(
     *          description="create order",
     *          required=true,
     *          @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="products",
     *                  type="array",
     *                  title="products",
     *                  @OA\Items(type="object", example={"id": 1, "quantity": 1})
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *          description="create order.",
     *          response=200,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=true
     *              )
     *          )
     *      )
     * )
     *
     * @param CheckoutRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function create(CheckoutRequest $request): JsonResponse
    {
        $cartItems = CartItemCollection::fromCheckoutData($request->input('products'));

        $userDTO = UserDto::fromEloquentModel($request->user());

        $this->databaseManager->transaction(function () use($request, $cartItems, $userDTO) {
            $order = Order::startForUser($userDTO->id);
            $order->addLinesFromCartItems($cartItems);
            $order->fullFill();
            $this->events->dispatch(
                new OrderFulfilled(
                    $order->total_price,
                    $order->id,
                    $userDTO->id,
                    $userDTO->email,
                    $cartItems,
                )
            );
        });

        return response()->json([
            'success' => true,
        ]);
    }
}
