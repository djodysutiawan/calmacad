<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FCMClient
{
    private string $serverKey;
    private string $endpoint = 'https://fcm.googleapis.com/fcm/send';

    public function __construct()
    {
        $this->serverKey = config('services.fcm.server_key');
    }

    /**
     * Kirim notifikasi ke satu device.
     */
    public function send(string $token, string $title, string $body, array $data = []): array
    {
        if (empty($this->serverKey) || empty($token)) {
            Log::warning('FCM send dilewati: server key atau token kosong.');

            return ['success' => false, 'reason' => 'missing_key_or_token'];
        }

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type'  => 'application/json',
        ])->post($this->endpoint, [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body'  => $body,
            ],
            'data' => $data,
        ]);

        return $response->json() ?? ['success' => false];
    }

    /**
     * Kirim notifikasi ke banyak device sekaligus (maks 1000 token per batch FCM).
     */
    public function sendBatch(array $tokens, string $title, string $body, array $data = []): array
    {
        $tokens = array_values(array_filter($tokens));

        if (empty($this->serverKey) || empty($tokens)) {
            Log::warning('FCM sendBatch dilewati: server key atau daftar token kosong.');

            return ['success' => false, 'reason' => 'missing_key_or_tokens'];
        }

        $results = [];

        // FCM legacy API membatasi 1000 registration_ids per request
        foreach (array_chunk($tokens, 1000) as $chunk) {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type'  => 'application/json',
            ])->post($this->endpoint, [
                'registration_ids' => $chunk,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'data' => $data,
            ]);

            $results[] = $response->json();
        }

        return $results;
    }
}