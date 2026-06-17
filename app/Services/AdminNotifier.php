<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\User;
use Throwable;

class AdminNotifier
{
    public static function notify(string $title, string $message, string $type = 'info', ?string $url = null): void
    {
        try {
            User::role(['Super Administrator', 'Administrator'])
                ->where('status', true)
                ->get(['id'])
                ->each(function (User $user) use ($title, $message, $type, $url) {
                    AdminNotification::create([
                        'user_id' => $user->id,
                        'type' => $type,
                        'title' => $title,
                        'message' => $message,
                        'url' => $url,
                    ]);
                });
        } catch (Throwable) {
            //
        }
    }
}
