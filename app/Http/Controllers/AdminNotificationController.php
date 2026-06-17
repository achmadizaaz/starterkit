<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index(Request $request)
    {
        return view('admin-notification.index', [
            'notifications' => $request->user()->adminNotifications()->latest()->paginate(15),
        ]);
    }

    public function read(Request $request, AdminNotification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === $request->user()->id, 403);

        $notification->update(['read_at' => now()]);

        return $notification->url
            ? redirect($notification->url)
            : back()->with('success', 'Notifikasi telah ditandai dibaca.');
    }

    public function readAll(Request $request): RedirectResponse
    {
        $request->user()->adminNotifications()->whereNull('read_at')->update(['read_at' => now()]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
