<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;
use OpenApi\Annotations as OA;

class CheckoutController extends Controller
{
    public function __construct(
        protected ProductStockManager $productStockManager
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
     */
    public function create(CheckoutRequest $request): JsonResponse
    {
        $cartItems = CartItemCollection::fromCheckoutData($request->input('products'));

        $orderTotal = $cartItems->sumTotal();

        $order = Order::query()->create([
            'user_id' => $request->user()->id,
            'total_price' => $orderTotal,
        ]);

        foreach ($cartItems as $cartItem) {
            $this->productStockManager->decrement($cartItem[0]->product->id, $cartItem[0]->quantity);

            $order->lines()->create([
                'product_id' => $cartItem[0]->product->id,
                'price' => $cartItem[0]->product->price,
                'quantity' => $cartItem[0]->quantity,
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
