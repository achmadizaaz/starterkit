<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class ActivityLogger
{
    public static function log(string $activity, ?Request $request = null): void
    {
        $request ??= request();
        $user = Auth::user();

        if (! $user) {
            return;
        }

        try {
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => Str::limit($activity, 240, ''),
                'ip_address' => $request->ip(),
                'user_agent' => Str::limit((string) $request->userAgent(), 1000, ''),
            ]);
        } catch (Throwable) {
            // Activity logging must never block the primary user action.
        }
    }
}
