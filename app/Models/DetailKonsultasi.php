<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'detail_konsultasi';

    public $timestamps = false;

    protected $fillable = [
        'konsultasi_id',
        'gejala_id',
        'cf_user',
        'cf_hasil',
    ];

    protected function casts(): array
    {
        return [
            'cf_user' => 'decimal:2',
            'cf_hasil' => 'decimal:6',
        ];
    }

    // ── Relasi ──────────────────────────────────────────────

    public function konsultasi(): BelongsTo
    {
        return $this->belongsTo(Konsultasi::class);
    }

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class);
    }
}