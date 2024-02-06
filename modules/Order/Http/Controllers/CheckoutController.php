<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Support\Collection;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;
use Modules\Product\Models\Product;
use Modules\Product\Warehouse\ProductStockManager;

class CheckoutController
{
    public function __construct(
        protected ProductStockManager $productStockManager
    )
    {

    }
    public function __invoke(CheckoutRequest $request): void
    {
        $cartItems = CartItemCollection::fromCheckoutData($request->input('products'));

        $orderTotal = $cartItems->sumTotal();

        $order = Order::query()->create([
            'user_id' => $request->user()->id,
            'total_price' => $orderTotal,
        ]);

        foreach ($cartItems as $cartItem) {
            $this->productStockManager->decrement($cartItem->id, $cartItem->quantity);

            $order->lines()->create([
                'product_id' => $cartItem->product->id,
                'price' => $cartItem->product->price,
                'quantity' => $cartItem->quantity,
            ]);
        }
    }
}
