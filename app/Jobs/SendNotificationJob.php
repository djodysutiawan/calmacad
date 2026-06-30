<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\NotificationLog;
use App\Services\FCMClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60; // detik, jeda antar percobaan ulang

    /**
     * Jalankan job: ambil semua notifikasi pending yang sudah jatuh tempo, lalu kirim via FCM.
     */
    public function handle(FCMClient $fcm): void
    {
        $pendingNotifications = Notification::with('user')
            ->where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->get();

        if ($pendingNotifications->isEmpty()) {
            return;
        }

        foreach ($pendingNotifications as $notification) {
            $this->sendOne($notification, $fcm);
        }
    }

    private function sendOne(Notification $notification, FCMClient $fcm): void
    {
        $user = $notification->user;

        if (! $user || empty($user->fcm_token)) {
            $notification->update(['status' => 'failed']);

            NotificationLog::create([
                'notification_id' => $notification->id,
                'fcm_response'    => ['error' => 'user_or_token_missing'],
                'status'          => 'failed',
                'sent_at'         => now(),
            ]);

            return;
        }

        $response = $fcm->send($user->fcm_token, $notification->title, $notification->body);
        $success  = is_array($response) && ($response['success'] ?? null) !== false;

        $notification->update([
            'status'  => $success ? 'sent' : 'failed',
            'sent_at' => now(),
        ]);

        NotificationLog::create([
            'notification_id' => $notification->id,
            'fcm_response'    => is_array($response) ? $response : null,
            'status'          => $success ? 'sent' : 'failed',
            'sent_at'         => now(),
        ]);
    }

    /**
     * Dipanggil otomatis oleh Laravel kalau job gagal terus setelah seluruh percobaan ($tries) habis.
     */
    public function failed(Throwable $exception): void
    {
        Log::error('SendNotificationJob gagal total: ' . $exception->getMessage());
    }
}