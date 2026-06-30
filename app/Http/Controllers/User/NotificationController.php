<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifikasi = Auth::user()
            ->notifications()
            ->where('status', 'sent')
            ->latest('sent_at')
            ->paginate(15);

        return view('user.notification.index', compact('notifikasi'));
    }

    /**
     * Disimpan dari resources/js/firebase-messaging.js setelah user mengizinkan notifikasi.
     */
    public function updateToken(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
        ]);

        Auth::user()->update(['fcm_token' => $validated['token']]);

        return response()->json(['message' => 'FCM token berhasil disimpan.']);
    }

    public function markAsRead(\App\Models\Notification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === Auth::id(), 403);

        $notification->markAsRead();

        return back();
    }
}