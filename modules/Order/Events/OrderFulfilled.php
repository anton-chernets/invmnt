<?php

namespace Modules\Order\Events;

use Modules\Product\CartItemCollection;

readonly class OrderFulfilled
{
    public function __construct(
        public float $total,
        public int $orderId,
        public int $userId,
        public string $userEmail,
        public CartItemCollection $cartItems,
    ) {

    }
}
