<?php

namespace Modules\Product;

use Illuminate\Support\Collection;
use Modules\Product\Models\Product;

class CartItemCollection
{
    /**
     * @param Collection<CartItem> $items
     */
    public function __construct(
        protected Collection $items
    ) {
        return $items;
    }

    public static function fromCheckoutData(array $data): CartItemCollection
    {
        $cartItems = collect($data)->map(
            function (array $productDetails) {
                return new CartItem(
                    ProductDTO::fromEloquentModel(Product::find($productDetails['id'])),
                    $productDetails['quantity'],
                );
            }
        );

        return new self($cartItems);
    }

    public function sumTotal(): float
    {
        return $this->items->sum(
            fn(CartItem $cartItem) => $cartItem->quantity * $cartItem->product->price
        );
    }

    /**
     * @return Collection<CartItem>
     */
    public function items(): Collection
    {
        return $this->items;
    }
}
