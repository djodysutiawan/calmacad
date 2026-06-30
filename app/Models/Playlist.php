<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Playlist extends Model
{
    use HasFactory;

    protected $table = 'playlist';

    public $timestamps = false;

    protected $fillable = [
        'tingkat_stres_id',
        'judul_lagu',
        'artis',
        'keterangan_terapeutik',
        'spotify_url',
        'youtube_url',
        'cover_url',
        'urutan',
    ];

    // ── Relasi ──────────────────────────────────────────────

    public function tingkatStres(): BelongsTo
    {
        return $this->belongsTo(TingkatStres::class);
    }

    // ── Scope ───────────────────────────────────────────────

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan');
    }
}