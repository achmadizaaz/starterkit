<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Throwable;

class AppSetting extends Model
{
    private static ?Collection $settingsCache = null;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $value = self::cached()->get($key);

        return filled($value) ? (string) $value : $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => filled($value) ? $value : null]
        );

        self::$settingsCache = null;
        Cache::forget('app_settings');
    }

    public static function cached(): Collection
    {
        if (self::$settingsCache !== null) {
            return self::$settingsCache;
        }

        self::$settingsCache = Cache::rememberForever('app_settings', function () {
            try {
                return self::query()->pluck('value', 'key');
            } catch (Throwable) {
                return collect();
            }
        });

        return self::$settingsCache;
    }

    public static function isPublicRegistrationOpen(): bool
    {
        if (self::getValue('registration_enabled', '1') !== '1') {
            return false;
        }

        try {
            $now = now();
            $startsAt = self::getValue('registration_starts_at');
            $endsAt = self::getValue('registration_ends_at');

            return (! $startsAt || $now->greaterThanOrEqualTo(Carbon::parse($startsAt)))
                && (! $endsAt || $now->lessThanOrEqualTo(Carbon::parse($endsAt)));
        } catch (Throwable) {
            return false;
        }
    }
}
