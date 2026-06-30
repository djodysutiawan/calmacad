<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    const UPDATED_AT = null; // tabel ini cuma punya created_at

    protected $fillable = [
        'user_id',
        'konsultasi_id',
        'type',
        'title',
        'body',
        'data',
        'scheduled_at',
        'sent_at',
        'status',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'scheduled_at' => 'datetime',
            'sent_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    // ── Relasi ──────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function konsultasi(): BelongsTo
    {
        return $this->belongsTo(Konsultasi::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }

    // ── Scope ───────────────────────────────────────────────

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeDueNow(Builder $query): Builder
    {
        return $query->where('status', 'pending')->where('scheduled_at', '<=', now());
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    // ── Helper ──────────────────────────────────────────────

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function markAsSent(): void
    {
        $this->update(['status' => 'sent', 'sent_at' => now()]);
    }
}