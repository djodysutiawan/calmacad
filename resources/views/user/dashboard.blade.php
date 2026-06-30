<x-layouts.user title="Dashboard">

    @php
        $orbColorMap = [
            'S00' => ['ring' => 'ring-level-normal/30', 'glow' => 'from-level-normal/40'],
            'S01' => ['ring' => 'ring-level-ringan/30', 'glow' => 'from-level-ringan/40'],
            'S02' => ['ring' => 'ring-level-sedang/30', 'glow' => 'from-level-sedang/40'],
            'S03' => ['ring' => 'ring-level-berat/30', 'glow' => 'from-level-berat/40'],
            'S04' => ['ring' => 'ring-level-kritis/30', 'glow' => 'from-level-kritis/40'],
        ];
        $orb = $konsultasiTerakhir
            ? ($orbColorMap[$konsultasiTerakhir->tingkatStres->kode] ?? ['ring' => 'ring-calm-400/30', 'glow' => 'from-calm-400/40'])
            : ['ring' => 'ring-calm-400/20', 'glow' => 'from-calm-400/20'];
        $isKritis = (bool) ($konsultasiTerakhir->is_kritis ?? false);
    @endphp

    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .5s cubic-bezier(.4,0,.2,1) both; }
        @media (prefers-reduced-motion: reduce) {
            .fade-up { animation: none; }
        }
        .lift { transition: transform .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease, background .25s ease; }
        .lift:hover { transform: translateY(-3px); }
    </style>

    {{-- ── Alert kondisi kritis — tampil paling atas, tidak bisa terlewat ── --}}
    @if ($isKritis)
        <div class="fade-up rounded-2xl glass p-5 mb-8 flex flex-col sm:flex-row sm:items-center gap-4"
             style="border-color: {{ $konsultasiTerakhir->tingkatStres->warna_hex }}55; box-shadow: 0 0 0 1px {{ $konsultasiTerakhir->tingkatStres->warna_hex }}33, var(--shadow-soft);">
            <div class="relative w-11 h-11 rounded-full flex items-center justify-center shrink-0"
                 style="background: {{ $konsultasiTerakhir->tingkatStres->warna_hex }}22; color: {{ $konsultasiTerakhir->tingkatStres->warna_hex }};">
                <span class="pulse-ring absolute inset-0 rounded-full" style="color: {{ $konsultasiTerakhir->tingkatStres->warna_hex }};"></span>
                <svg class="relative w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 9v4M12 17h.01M10.29 3.86l-8.18 14.18A2 2 0 0 0 4 21h16a2 2 0 0 0 1.89-2.96L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-display text-base font-semibold t1">Kamu menunjukkan tanda kondisi kritis</p>
                <p class="text-sm t2 mt-0.5">Kami sudah memberitahu tim konselor kampus. Jangan ragu menghubungi bantuan di bawah ini — kamu tidak sendirian.</p>
            </div>
            <div class="flex flex-wrap gap-2 sm:shrink-0">
                <a href="tel:119" class="lift inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-medium text-white"
                   style="background: {{ $konsultasiTerakhir->tingkatStres->warna_hex }};">
                    📞 Hotline 119 ext. 8
                </a>
                <a href="{{ route('user.riwayat.show', $konsultasiTerakhir) }}" class="lift hover-surf inline-flex items-center rounded-full border hairline px-4 py-2 text-sm font-medium t1">
                    Lihat Panduan
                </a>
            </div>
        </div>
    @endif

    <div class="grid md:grid-cols-[280px_1fr] gap-10 items-center md:items-start">

        {{-- ── Signature element: orb status, berdenyut pelan ── --}}
        <div class="fade-up flex flex-col items-center text-center" style="animation-delay: .05s">
            <div class="relative w-48 h-48 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full bg-gradient-to-br {{ $orb['glow'] }} to-transparent
                            motion-safe:animate-[breathe_5s_ease-in-out_infinite]"></div>
                <div class="lift relative w-32 h-32 rounded-full glass ring-8 {{ $orb['ring'] }}
                            flex flex-col items-center justify-center">
                    @if ($konsultasiTerakhir)
                        <span class="font-display text-2xl font-semibold t1">
                            {{ number_format($konsultasiTerakhir->cf_persen, 0) }}%
                        </span>
                        <span class="text-[11px] t3 font-mono uppercase tracking-wide">indeks stres</span>
                    @else
                        <span class="text-sm t3 px-4">Belum ada data</span>
                    @endif
                </div>
            </div>

            @if ($konsultasiTerakhir)
                <div class="mt-5">
                    <x-badge-tingkat :tingkat="$konsultasiTerakhir->tingkatStres" />
                </div>
                <p class="mt-2 text-xs t3">
                    Konsultasi terakhir {{ $konsultasiTerakhir->created_at->diffForHumans() }}
                </p>
            @else
                <a href="{{ route('konsultasi.index') }}" class="mt-5 text-xs t2 underline underline-offset-4 hover:t1">
                    Mulai konsultasi pertamamu
                </a>
            @endif
        </div>

        {{-- ── Konten utama ── --}}
        <div class="space-y-8">

            <div class="fade-up" style="animation-delay: .1s">
                <h2 class="font-display text-2xl font-semibold t1">
                    Halo, {{ explode(' ', auth()->user()->name)[0] }} 👋
                </h2>
                <p class="t2 mt-1">
                    @if ($konsultasiTerakhir)
                        Begini kira-kira kondisimu berdasarkan konsultasi terakhir. Tetap pantau secara berkala, ya.
                    @else
                        Kamu belum pernah konsultasi. Yuk mulai kenali kondisi stresmu sekarang.
                    @endif
                </p>
            </div>

            <div class="grid sm:grid-cols-3 gap-4 fade-up" style="animation-delay: .15s">
                <div class="lift rounded-2xl glass p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs t3 font-mono uppercase tracking-wide">Total Konsultasi</p>
                        <svg class="w-4 h-4 t3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <p class="font-display text-3xl font-semibold mt-1" style="color: #7FA98D;">{{ $totalKonsultasi }}</p>
                </div>
                <div class="lift rounded-2xl glass p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs t3 font-mono uppercase tracking-wide">Notifikasi Baru</p>
                        <svg class="w-4 h-4 t3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9"/></svg>
                    </div>
                    <p class="font-display text-3xl font-semibold mt-1" style="color: #7FA98D;">{{ $notifBelumDibaca }}</p>
                </div>
                <div class="lift rounded-2xl glass p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs t3 font-mono uppercase tracking-wide">Cek Ulang Berikutnya</p>
                        <svg class="w-4 h-4 t3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    </div>
                    <p class="font-display text-base font-medium t1 mt-2.5">
                        {{ $konsultasiTerakhir?->created_at?->addDays(7)->translatedFormat('d M Y') ?? '—' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 fade-up" style="animation-delay: .2s">
                <a href="{{ route('konsultasi.index') }}"
                   class="lift inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90 active:scale-95"
                   style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                    Mulai Konsultasi Baru
                </a>
                @if ($konsultasiTerakhir)
                    <a href="{{ route('user.riwayat.show', $konsultasiTerakhir) }}"
                       class="lift hover-surf inline-flex items-center rounded-full border px-5 py-2.5 text-sm font-medium t1 transition active:scale-95"
                       style="border-color: var(--border-glass);">
                        Lihat Rekomendasi Terakhir
                    </a>
                @endif
            </div>

            {{-- ── Akses cepat — mengisi ruang & memberi arah lanjutan, bukan dekorasi ── --}}
            <div class="grid sm:grid-cols-2 gap-4 fade-up" style="animation-delay: .25s">
                <a href="{{ route('user.riwayat') }}" class="lift hover-surf rounded-2xl glass p-5 flex items-center gap-4 group">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="background: rgba(127,169,141,0.14); color: #7FA98D;">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5M12 7v5l4 2"/></svg>
                    </span>
                    <div class="flex-1">
                        <p class="text-sm font-medium t1">Riwayat Konsultasi</p>
                        <p class="text-xs t3">Lihat semua hasil sebelumnya</p>
                    </div>
                    <svg class="w-4 h-4 t3 transition group-hover:translate-x-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </a>
                <a href="{{ route('user.profile.edit') }}" class="lift hover-surf rounded-2xl glass p-5 flex items-center gap-4 group">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="background: rgba(63,167,150,0.14); color: #3FA796;">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
                    </span>
                    <div class="flex-1">
                        <p class="text-sm font-medium t1">Pengaturan Profil</p>
                        <p class="text-xs t3">Foto, notifikasi, dan password</p>
                    </div>
                    <svg class="w-4 h-4 t3 transition group-hover:translate-x-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Tips ringan — relevan dengan tema, mengisi ruang kosong di bawah secara bermakna ── --}}
    <div class="mt-12 fade-up" style="animation-delay: .3s">
        <p class="text-xs t3 font-mono uppercase tracking-wide mb-4">Sambil menunggu cek ulang</p>
        <div class="grid sm:grid-cols-3 gap-4">
            <div class="lift rounded-2xl glass p-5">
                <span class="text-xl">🌬️</span>
                <p class="text-sm font-medium t1 mt-2">Latihan napas 4-7-8</p>
                <p class="text-xs t2 mt-1">Tarik napas 4 detik, tahan 7 detik, embuskan 8 detik. Ulangi 4 kali.</p>
            </div>
            <div class="lift rounded-2xl glass p-5">
                <span class="text-xl">✍️</span>
                <p class="text-sm font-medium t1 mt-2">Jurnal singkat</p>
                <p class="text-xs t2 mt-1">Tulis 3 hal yang kamu rasakan hari ini, tanpa perlu menilai benar-salah.</p>
            </div>
            <div class="lift rounded-2xl glass p-5">
                <span class="text-xl">🎧</span>
                <p class="text-sm font-medium t1 mt-2">Putar playlist tenang</p>
                <p class="text-xs t2 mt-1">Cek rekomendasi musik terapeutik di hasil konsultasi terakhirmu.</p>
            </div>
        </div>
    </div>

</x-layouts.user>