<?php

namespace Modules\Order\Http\Controllers;

use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;

class CheckoutController
{
    public function __invoke(CheckoutRequest $request)
    {
        $products = collect($request->input('products'))->map(
            function (array $productDetails) {
                return [
                    'product' => Product::find($productDetails['id']),
                    'quantity' => $productDetails['quantity']
                ];
            }
        );

        $orderTotal = $products->sum(
            fn(array $productDetails) => $productDetails['quantity'] * $productDetails['product']->price
        );

        $order = Order::query()->create([
            'status' => 'new',
            'total_price' => $orderTotal,
            'user_id' => $request->user()->id,
        ]);

        foreach ($products as $product) {
            $order->lines()->create([
                'status' => Order::STATUS_NEW,
                'product_id' => $product->id,
                'quantity' => $product->quantity,
                'price' => $product->price,
                'total_price' => $orderTotal,
                'user_id' => $request->user()->id,
            ]);
        }
    }
}
