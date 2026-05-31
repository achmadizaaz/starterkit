<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Throwable;

class AppSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return self::cached()->get($key) ?: $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => filled($value) ? $value : null]
        );

        Cache::forget('app_settings');
    }

    public static function cached()
    {
        return Cache::rememberForever('app_settings', function () {
            try {
                return self::query()->pluck('value', 'key');
            } catch (Throwable) {
                return collect();
            }
        });
    }
}
