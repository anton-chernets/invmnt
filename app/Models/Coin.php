<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Coin
 *
 * @property int $id
 * @property int $currency_id
 * @property string $name
 * @property string $slug
 * @property int|null $count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Currency $currency
 */
class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'name',
        'slug',
        'count',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
