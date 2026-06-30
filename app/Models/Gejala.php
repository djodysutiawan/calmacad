<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejala';

    protected $fillable = [
        'kode',
        'nama_gejala',
        'kategori',
        'cf_pakar',
        'deskripsi',
        'is_active',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'cf_pakar' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // ── Relasi ──────────────────────────────────────────────

    public function detailKonsultasi(): HasMany
    {
        return $this->hasMany(DetailKonsultasi::class);
    }

    // ── Scope ───────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan');
    }

    public function scopeKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }

    // ── Helper ──────────────────────────────────────────────

    public function isKritis(): bool
    {
        return $this->kode === 'G25' || $this->kategori === 'kritis';
    }
}