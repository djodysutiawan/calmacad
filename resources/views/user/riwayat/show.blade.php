
@php
    // Helper kecil: ubah URL Spotify/YouTube biasa jadi URL embed supaya bisa diputar langsung di halaman.
    function calmacad_embed_url(?string $spotifyUrl, ?string $youtubeUrl): ?array {
        if ($spotifyUrl) {
            if (preg_match('~open\.spotify\.com/(?:intl-\w+/)?(track|album|playlist)/([a-zA-Z0-9]+)~', $spotifyUrl, $m)) {
                return ['provider' => 'spotify', 'src' => "https://open.spotify.com/embed/{$m[1]}/{$m[2]}?utm_source=generator"];
            }
        }
        if ($youtubeUrl) {
            $id = null;
            if (preg_match('~youtu\.be/([a-zA-Z0-9_-]+)~', $youtubeUrl, $m)) {
                $id = $m[1];
            } elseif (preg_match('~[?&]v=([a-zA-Z0-9_-]+)~', $youtubeUrl, $m)) {
                $id = $m[1];
            } elseif (preg_match('~youtube\.com/embed/([a-zA-Z0-9_-]+)~', $youtubeUrl, $m)) {
                $id = $m[1];
            }
            if ($id) {
                return ['provider' => 'youtube', 'src' => "https://www.youtube.com/embed/{$id}?autoplay=1"];
            }
        }
        return null;
    }
@endphp

<x-layouts.user title="Detail Konsultasi">

    <a href="{{ route('user.riwayat') }}" class="inline-flex items-center gap-1.5 text-sm t2 hover:opacity-80 mb-6 transition group">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:-translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        Kembali ke Riwayat
    </a>

    {{-- ── Ringkasan hasil ── --}}
    <div class="rounded-2xl glass p-7 mb-6 flex flex-col sm:flex-row sm:items-center gap-6">
        <div class="shrink-0 w-24 h-24 rounded-full flex flex-col items-center justify-center"
             style="background: {{ $konsultasi->tingkatStres?->warna_hex ?? '#94A3B8' }}1f; box-shadow: inset 0 0 0 2px {{ $konsultasi->tingkatStres?->warna_hex ?? '#94A3B8' }}55;">
            <span class="font-display text-2xl font-semibold" style="color: {{ $konsultasi->tingkatStres?->warna_hex ?? '#94A3B8' }};">
                {{ number_format($konsultasi->cf_persen, 0) }}%
            </span>
            <span class="text-[10px] t3 font-mono uppercase tracking-wide">indeks</span>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="font-display text-xl font-semibold t1">{{ $konsultasi->tingkatStres?->nama ?? 'Tidak diketahui' }}</h1>
                @if ($konsultasi->tingkatStres)
                    <x-badge-tingkat :tingkat="$konsultasi->tingkatStres" />
                @endif
            </div>
            <p class="text-sm t2 mt-2">{{ $konsultasi->tingkatStres?->definisi ?? 'Hasil ini dihitung berdasarkan gejala yang kamu pilih saat konsultasi.' }}</p>
            <p class="text-xs t3 mt-3" title="{{ $konsultasi->created_at->translatedFormat('d M Y, H:i') }}">
                Dikonsultasikan {{ $konsultasi->created_at->translatedFormat('d F Y, H:i') }}
            </p>
        </div>
    </div>

    @if ($konsultasi->is_kritis)
        <div class="rounded-2xl mb-6 px-5 py-4 text-sm" style="background: rgba(153,27,27,0.1); border: 1px solid rgba(153,27,27,0.35); color: #991B1B;">
            <p class="font-semibold mb-1">⚠ Status Kritis Terdeteksi</p>
            <p>Hasil konsultasi ini menunjukkan kondisi yang memerlukan perhatian profesional segera. Jika kamu memiliki pikiran untuk menyakiti diri sendiri, segera hubungi hotline kesehatan jiwa: <strong>Into The Light Indonesia 119 ext 8</strong> atau <strong>Yayasan Pulih (021) 788-42580</strong>.</p>
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-6">

        {{-- ── Gejala yang dipilih ── --}}
        <div class="rounded-2xl glass p-6">
            <h2 class="font-display text-base font-semibold t1 mb-4">Gejala yang Kamu Pilih</h2>
            @if (($gejalaTerpilih ?? collect())->isEmpty())
                <p class="text-sm t3">Tidak ada rincian gejala untuk konsultasi ini.</p>
            @else
                <ul class="space-y-2.5">
                    @foreach ($gejalaTerpilih as $g)
                        <li class="flex items-center justify-between gap-3 text-sm">
                            <span class="t2">{{ $g->nama_gejala }}</span>
                            @if (isset($g->cf_user_value))
                                <span class="font-mono text-xs t3 shrink-0">CF {{ number_format($g->cf_user_value * 100, 0) }}%</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- ── Rekomendasi ── --}}
        <div class="rounded-2xl glass p-6">
            <h2 class="font-display text-base font-semibold t1 mb-4">Rekomendasi untukmu</h2>
            @if (($rekomendasiList ?? collect())->isEmpty())
                <p class="text-sm t3">Belum ada rekomendasi khusus untuk tingkat ini.</p>
            @else
                @foreach (['penanganan' => 'Penanganan', 'healing' => 'Healing yang Disarankan'] as $kategori => $label)
                    @php $items = $rekomendasiList->where('kategori', $kategori); @endphp
                    @if ($items->isNotEmpty())
                        <div class="mb-5 last:mb-0">
                            <h3 class="text-[10px] font-mono uppercase tracking-wider t3 mb-2.5">{{ $label }}</h3>
                            <ul class="space-y-3">
                                @foreach ($items as $r)
                                    <li class="flex items-start gap-3 text-sm">
                                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full shrink-0" style="background: #7FA98D;"></span>
                                        <span class="t2">{{ $r->konten }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    {{-- ── Playlist pemulihan — bisa diputar langsung ── --}}
    @php $playlist = $konsultasi->tingkatStres?->playlist ?? collect(); @endphp
    @if ($playlist->isNotEmpty())
        <div x-data="{ playing: null }" class="rounded-2xl glass p-6 mt-6">
            <div class="flex items-center gap-2.5 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="#7FA98D" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                </svg>
                <h2 class="font-display text-base font-semibold t1">Playlist Pemulihan</h2>
            </div>
            <p class="text-xs t3 mb-5">Dipilih khusus untuk tingkat stres <span class="t2">{{ $konsultasi->tingkatStres->nama }}</span>. Tekan tombol putar untuk mendengarkan.</p>

            <div class="space-y-3">
                @foreach ($playlist as $lagu)
                    @php $embed = calmacad_embed_url($lagu->spotify_url ?? null, $lagu->youtube_url ?? null); @endphp
                    <div class="rounded-xl overflow-hidden transition" style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
                        <div class="flex items-center gap-4 p-3.5">
                            {{-- Cover / placeholder --}}
                            <div class="shrink-0 w-12 h-12 rounded-lg overflow-hidden flex items-center justify-center" style="background: rgba(127,169,141,0.14);">
                                @if (!empty($lagu->cover_url))
                                    <img src="{{ $lagu->cover_url }}" alt="" class="w-full h-full object-cover" loading="lazy">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#7FA98D" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="t1 text-sm font-medium truncate">{{ $lagu->judul_lagu }}</p>
                                <p class="text-xs t3 truncate">{{ $lagu->artis }}</p>
                                @if (!empty($lagu->keterangan_terapeutik))
                                    <p class="text-xs t3 mt-1 leading-relaxed line-clamp-2">{{ $lagu->keterangan_terapeutik }}</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-1.5 shrink-0">
                                @if ($embed)
                                    <button type="button"
                                            @click="playing = playing === {{ $lagu->id }} ? null : {{ $lagu->id }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-full text-white transition hover:opacity-90 active:scale-95"
                                            style="background: linear-gradient(135deg, #7FA98D, #3FA796);"
                                            :aria-label="playing === {{ $lagu->id }} ? 'Tutup pemutar' : 'Putar lagu'">
                                        <svg x-show="playing !== {{ $lagu->id }}" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                        <svg x-show="playing === {{ $lagu->id }}" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 6h12v12H6z"/></svg>
                                    </button>
                                @else
                                    <span class="text-[10px] t3 font-mono uppercase tracking-wide px-2">Tidak ada sumber</span>
                                @endif

                                @if (!empty($lagu->spotify_url))
                                    <a href="{{ $lagu->spotify_url }}" target="_blank" rel="noopener" class="icon-btn w-9 h-9 rounded-full flex items-center justify-center t3" aria-label="Buka di Spotify" style="transition: background-color .18s ease;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                                    </a>
                                @endif
                                @if (!empty($lagu->youtube_url))
                                    <a href="{{ $lagu->youtube_url }}" target="_blank" rel="noopener" class="icon-btn w-9 h-9 rounded-full flex items-center justify-center t3" aria-label="Buka di YouTube" style="transition: background-color .18s ease;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M23.5 6.2a3.02 3.02 0 0 0-2.12-2.14C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.38.56A3.02 3.02 0 0 0 .5 6.2 31.6 31.6 0 0 0 0 12a31.6 31.6 0 0 0 .5 5.8 3.02 3.02 0 0 0 2.12 2.14C4.5 20.5 12 20.5 12 20.5s7.5 0 9.38-.56a3.02 3.02 0 0 0 2.12-2.14A31.6 31.6 0 0 0 24 12a31.6 31.6 0 0 0-.5-5.8zM9.6 15.6V8.4l6.4 3.6z"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Player tersemat — muncul saat tombol putar ditekan --}}
                        @if ($embed)
                            <div x-show="playing === {{ $lagu->id }}"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-250"
                                 x-transition:enter-start="opacity-0 -translate-y-2 max-h-0"
                                 x-transition:enter-end="opacity-100 translate-y-0 max-h-[200px]"
                                 class="px-3.5 pb-3.5">
                                <template x-if="playing === {{ $lagu->id }}">
                                    <div class="rounded-lg overflow-hidden" style="border: 1px solid var(--border-glass);">
                                        @if ($embed['provider'] === 'spotify')
                                            <iframe style="border-radius: 8px;" src="{{ $embed['src'] }}" width="100%" height="152" frameborder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                                        @else
                                            <iframe width="100%" height="220" src="{{ $embed['src'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                                        @endif
                                    </div>
                                </template>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('konsultasi.index') }}"
           class="inline-flex items-center rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
           style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
            Konsultasi Lagi
        </a>
        <a href="{{ route('user.dashboard') }}"
           class="inline-flex items-center rounded-full border px-5 py-2.5 text-sm font-medium t1 hover-surf transition"
           style="border-color: var(--border-glass);">
            Kembali ke Dashboard
        </a>
    </div>

</x-layouts.user>