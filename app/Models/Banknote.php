<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Banknote
 *
 * @property int $id
 * @property int $currency_id
 * @property string $name
 * @property string|null $url
 * @property string $slug
 * @property int|null $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Currency $currency
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banknote whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Banknote extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'name',
        'url',
        'slug',
        'count',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
