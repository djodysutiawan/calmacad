<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}

    public function index(): View
    {
        $notifications = Notification::with('user')->latest()->paginate(20);
        $kritisCount = Notification::where('type', 'kritis')->whereNull('read_at')->count();
        $users = \App\Models\User::where('role', 'user')->orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.notification.index', compact('notifications', 'kritisCount', 'users'));
    }

    public function broadcast(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'target' => ['required', 'in:all,role,user'],
            'role'   => ['required_if:target,role', 'in:user,admin'],
            'user_id'=> ['required_if:target,user', 'exists:users,id'],
            'title'  => ['required', 'string', 'max:150'],
            'body'   => ['required', 'string'],
        ]);

        $jumlahTerkirim = match ($validated['target']) {
            'all'  => $this->notificationService->broadcastToAll($validated['title'], $validated['body']),
            'role' => $this->notificationService->broadcastToRole($validated['role'], $validated['title'], $validated['body']),
            'user' => $this->notificationService->sendImmediate($validated['user_id'], $validated['title'], $validated['body']) ? 1 : 0,
        };

        return redirect()
            ->route('admin.notif.index')
            ->with('success', "Notifikasi berhasil dikirim ke {$jumlahTerkirim} pengguna.");
    }
}