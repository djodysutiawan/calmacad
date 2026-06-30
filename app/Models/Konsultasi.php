<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasi';

    protected $fillable = [
        'user_id',
        'guest_token',
        'nama_responden',
        'jenis_kelamin',
        'status_akademik',
        'cf_combine',
        'cf_persen',
        'tingkat_stres_id',
        'is_kritis',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'cf_combine' => 'decimal:6',
            'cf_persen' => 'decimal:2',
            'is_kritis' => 'boolean',
        ];
    }

    // ── Relasi ──────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tingkatStres(): BelongsTo
    {
        return $this->belongsTo(TingkatStres::class);
    }

    public function detailKonsultasi(): HasMany
    {
        return $this->hasMany(DetailKonsultasi::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    // ── Scope ───────────────────────────────────────────────

    public function scopeKritis(Builder $query): Builder
    {
        return $query->where('is_kritis', true);
    }

    public function scopeGuest(Builder $query): Builder
    {
        return $query->whereNull('user_id');
    }

    public function scopeTerdaftar(Builder $query): Builder
    {
        return $query->whereNotNull('user_id');
    }

    // ── Helper ──────────────────────────────────────────────

    public function isGuest(): bool
    {
        return is_null($this->user_id);
    }
}