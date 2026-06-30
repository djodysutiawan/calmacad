<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi';

    protected $fillable = [
        'tingkat_stres_id',
        'kategori',
        'judul',
        'konten',
        'urutan',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function tingkatStres(): BelongsTo
    {
        return $this->belongsTo(TingkatStres::class);
    }

    // ── Scope ───────────────────────────────────────────────

    public function scopeKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan');
    }
}