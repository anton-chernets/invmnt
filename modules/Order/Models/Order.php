<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Order\Database\Factories\OrderFactory;
use Modules\Order\Exceptions\OrderMissingOrderLinesException;
use Modules\Product\CartItemCollection;

/**
 * Modules\Order\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property string $total_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Order\Models\OrderLine> $lines
 * @property-read int|null $lines_count
 * @method static \Modules\Order\Database\Factories\OrderFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    const COMPLETED = 'completed';
    const PENDING = 'pending';

    protected $fillable = [
        'user_id',
        'total_price',
    ];

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }

    public static function newFactory(): OrderFactory
    {
        return new OrderFactory();
    }

    public static function startForUser(int $userId): self
    {
        return self::make([
            'user_id' => $userId,
//            'status' => self::PENDING,//TODO
        ]);
    }

    public function addLinesFromCartItems(CartItemCollection $itemCollection): void
    {
        foreach ($itemCollection->items() as $cartItem) {
            $this->lines->push(
                OrderLine::make([
                    'product_id' => $cartItem->product->id,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                ])
            );
        }

        $this->total_price = $this->lines->sum(fn(OrderLine $line) => $line->price);
    }

    /**
     * @throws OrderMissingOrderLinesException
     */
    public function fullFill(): void
    {
        if($this->lines->isEmpty())
            throw new OrderMissingOrderLinesException();
//        $this->status = self::COMPLETED;//TODO

        $this->save();
        $this->lines()->saveMany($this->lines);
    }
}
