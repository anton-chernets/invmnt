<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TelegramUser
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property int $telegram_id
 * @property bool $subscribed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereTelegramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereUsername($value)
 * @mixin \Eloquent
 */
class TelegramUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'telegram_id',
        'subscribed',
    ];

    protected $casts = [
        'subscribed' => 'boolean',
    ];
}
