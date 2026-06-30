<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TingkatStres extends Model
{
    use HasFactory;

    protected $table = 'tingkat_stres';

    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'definisi',
        'ciri_khas',
        'min_cf',
        'max_cf',
        'min_gejala',
        'max_gejala',
        'warna_hex',
        'icon',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'min_cf' => 'decimal:4',
            'max_cf' => 'decimal:4',
        ];
    }

    // ── Relasi ──────────────────────────────────────────────

    public function rekomendasi(): HasMany
    {
        return $this->hasMany(Rekomendasi::class);
    }

    // public function playlist(): HasMany
    // {
    //     return $this->hasMany(Playlist::class);
    // }
    public function playlist()
    {
        return $this->hasMany(\App\Models\Playlist::class);
    }

    public function konsultasi(): HasMany
    {
        return $this->hasMany(Konsultasi::class);
    }

    // ── Helper ──────────────────────────────────────────────

    public function isKritis(): bool
    {
        return $this->kode === 'S04';
    }
}