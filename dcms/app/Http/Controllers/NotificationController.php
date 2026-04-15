<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, string $notificationId): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user, 403);

        $notification = $user->notifications()->whereKey($notificationId)->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user, 403);

        $user->unreadNotifications()->update([
            'read_at' => now(),
        ]);

        return back();
    }
}
