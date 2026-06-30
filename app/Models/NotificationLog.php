<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notification_logs';

    public $timestamps = false;

    protected $fillable = [
        'notification_id',
        'fcm_response',
        'status',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'fcm_response' => 'array',
            'sent_at' => 'datetime',
        ];
    }

    // ── Relasi ──────────────────────────────────────────────

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}