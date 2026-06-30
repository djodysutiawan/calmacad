<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationLog;
use App\Models\User;
use App\Services\FCMClient;

class NotificationService
{
    public function __construct(private FCMClient $fcm) {}

    /**
     * Jadwalkan reminder cek ulang stres, 7 hari setelah konsultasi.
     */
    public function scheduleReminder(int $userId, int $konsultasiId): Notification
    {
        return Notification::create([
            'user_id'       => $userId,
            'konsultasi_id' => $konsultasiId,
            'type'          => 'reminder',
            'title'         => 'Waktunya Cek Ulang!',
            'body'          => 'Sudah 7 hari sejak konsultasi terakhirmu. Yuk cek kondisi stresmu lagi di CalmAcad.',
            'scheduled_at'  => now()->addDays(7),
            'status'        => 'pending',
        ]);
    }

    /**
     * Kirim notifikasi langsung ke satu user (tanpa antrean).
     */
    public function sendImmediate(int $userId, string $title, string $body): bool
    {
        $user = User::find($userId);

        if (! $user || empty($user->fcm_token)) {
            return false;
        }

        $notification = Notification::create([
            'user_id'      => $userId,
            'type'         => 'info',
            'title'        => $title,
            'body'         => $body,
            'scheduled_at' => now(),
            'status'       => 'pending',
        ]);

        $response = $this->fcm->send($user->fcm_token, $title, $body);
        $this->finalize($notification, $response);

        return true;
    }

    /**
     * Broadcast ke seluruh user yang punya FCM token.
     */
    public function broadcastToAll(string $title, string $body): int
    {
        $users = User::whereNotNull('fcm_token')->get();

        return $this->broadcastToUsers($users, $title, $body);
    }

    /**
     * Broadcast ke user dengan role tertentu.
     */
    public function broadcastToRole(string $role, string $title, string $body): int
    {
        $users = User::where('role', $role)->whereNotNull('fcm_token')->get();

        return $this->broadcastToUsers($users, $title, $body);
    }

    /**
     * Kirim alert kritis ke semua admin saat gejala G25 aktif.
     */
    public function sendKritisAlert(int $konsultasiId): void
    {
        $admins = User::where('role', 'admin')->whereNotNull('fcm_token')->get();

        foreach ($admins as $admin) {
            $notification = Notification::create([
                'user_id'       => $admin->id,
                'konsultasi_id' => $konsultasiId,
                'type'          => 'kritis',
                'title'         => 'ALERT: Kondisi Kritis Terdeteksi',
                'body'          => "Ada pengguna terindikasi kondisi kritis pada konsultasi #{$konsultasiId}. Segera tindak lanjuti.",
                'scheduled_at'  => now(),
                'status'        => 'pending',
            ]);

            $response = $this->fcm->send($admin->fcm_token, $notification->title, $notification->body);
            $this->finalize($notification, $response);
        }
    }

    /**
     * Helper internal: buat record notifikasi per user lalu kirim via FCM batch.
     */
    private function broadcastToUsers($users, string $title, string $body): int
    {
        $notifications = [];

        foreach ($users as $user) {
            $notifications[] = Notification::create([
                'user_id'      => $user->id,
                'type'         => 'broadcast',
                'title'        => $title,
                'body'         => $body,
                'scheduled_at' => now(),
                'status'       => 'pending',
            ]);
        }

        $tokens = $users->pluck('fcm_token')->toArray();
        $response = $this->fcm->sendBatch($tokens, $title, $body);

        foreach ($notifications as $notification) {
            $this->finalize($notification, $response);
        }

        return count($notifications);
    }

    /**
     * Update status notifikasi + simpan log respons FCM.
     */
    private function finalize(Notification $notification, $fcmResponse): void
    {
        $success = is_array($fcmResponse) && ($fcmResponse['success'] ?? null) !== false;

        $notification->update([
            'status'  => $success ? 'sent' : 'failed',
            'sent_at' => now(),
        ]);

        NotificationLog::create([
            'notification_id' => $notification->id,
            'fcm_response'    => is_array($fcmResponse) ? $fcmResponse : null,
            'status'          => $success ? 'sent' : 'failed',
            'sent_at'         => now(),
        ]);
    }
}