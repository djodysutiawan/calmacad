<x-layouts.admin title="Dashboard">

    @php
        $total = max($distribusiTingkat->sum('konsultasi_count'), 1);
        $kritisPct = $totalKonsultasi > 0 ? round(($totalKritis / $totalKonsultasi) * 100) : 0;
        $pulseColor = $kritisPct >= 30 ? '#E8775A' : ($kritisPct >= 10 ? '#E0B05E' : '#7FA98D');
        $circumference = 2 * M_PI * 80; // r=80

        // Radar 5 sumbu (satu per tingkat stres) — bentuk poligon dibangun dari
        // proporsi data asli, bukan dekorasi. Inilah elemen tanda tangan halaman ini.
        $n = max($distribusiTingkat->count(), 1);
        $cx = 130; $cy = 130; $rMax = 96;
        $radarPoints = collect();
        $axisLines = collect();
        foreach ($distribusiTingkat->values() as $i => $t) {
            $angle = (-90 + ($i * 360 / $n)) * M_PI / 180;
            $h = $total > 0 ? ($t->konsultasi_count / $total) : 0;
            $r = 22 + $h * $rMax; // titik tengah min, supaya tetap terlihat sbg poligon walau 0
            $radarPoints->push(($cx + $r * cos($angle)) . ',' . ($cy + $r * sin($angle)));
            $axisLines->push(['x2' => $cx + $rMax * cos($angle), 'y2' => $cy + $rMax * sin($angle), 'lx' => $cx + ($rMax + 16) * cos($angle), 'ly' => $cy + ($rMax + 16) * sin($angle), 'label' => $t->kode ?? $t->nama, 'color' => $t->warna_hex]);
        }
        $radarPath = $radarPoints->implode(' ');
    @endphp

    {{-- ── Page heading ── --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
        <div>
            <p class="text-xs font-mono uppercase tracking-[0.22em] t3 mb-2">{{ now()->translatedFormat('l, d F Y') }}</p>
            <h1 class="font-display text-[32px] leading-tight font-semibold">Ringkasan hari ini</h1>
        </div>
        <div class="flex items-center gap-2 rounded-full glass pl-3 pr-4 py-2 w-fit">
            <span class="relative w-1.5 h-1.5 text-sage-400 pulse-ring">
                <span class="absolute inset-0 rounded-full bg-sage-400"></span>
            </span>
            <span class="text-xs font-mono t2 uppercase tracking-wide">Data langsung</span>
        </div>
    </div>

    {{-- ── Hero: radial "Denyut Stres" + radar 5 tingkat berdampingan ── --}}
    <div class="grid lg:grid-cols-5 gap-5 mb-6">

        <div class="lg:col-span-2 rounded-2xl glass p-7 relative overflow-hidden flex flex-col items-center justify-center text-center">
            <p class="text-[10px] font-mono uppercase tracking-[0.22em] t3 mb-5 self-start">Indeks Kritis</p>
            <div class="relative w-48 h-48" x-data="{ pct: 0 }" x-init="let t=0; const target={{ $kritisPct }}; const iv=setInterval(()=>{ t++; pct = Math.min(target, Math.round(target*t/30)); if(t>=30) clearInterval(iv); }, 16);">
                <svg viewBox="0 0 200 200" class="w-48 h-48 -rotate-90">
                    <circle cx="100" cy="100" r="80" fill="none" style="stroke: var(--border-glass);" stroke-width="14"/>
                    <circle cx="100" cy="100" r="80" fill="none"
                            stroke="{{ $pulseColor }}" stroke-width="14" stroke-linecap="round"
                            stroke-dasharray="{{ $circumference }}"
                            style="stroke-dashoffset: {{ $circumference }}; filter: drop-shadow(0 0 10px {{ $pulseColor }}88);
                                   animation: ring-fill 1.6s cubic-bezier(.16,1,.3,1) forwards .2s;
                                   --target-offset: {{ $circumference - ($kritisPct / 100) * $circumference }};"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-display text-[44px] font-semibold leading-none" x-text="pct + '%'"></span>
                    <span class="text-[10px] font-mono uppercase tracking-wider t3 mt-2">kritis</span>
                </div>
            </div>
            <p class="text-sm t2 mt-6 leading-relaxed max-w-[26ch]">
                {{ $totalKritis }} dari {{ number_format($totalKonsultasi) }} konsultasi tergolong kritis —
                {{ $kritisPct >= 30 ? 'perlu perhatian segera.' : ($kritisPct >= 10 ? 'tetap pantau perkembangannya.' : 'kondisi keseluruhan tenang.') }}
            </p>
        </div>

        <div class="lg:col-span-3 rounded-2xl glass p-7 relative overflow-hidden">
            <div class="flex items-center justify-between mb-1">
                <p class="text-[10px] font-mono uppercase tracking-[0.22em] t3">Peta Distribusi 5 Tingkat</p>
                <span class="text-xs font-mono t3">{{ number_format($total) }} kasus</span>
            </div>
            <div class="flex items-center justify-center">
                <svg viewBox="0 0 260 260" class="w-64 h-64">
                    {{-- grid web --}}
                    @foreach ([0.25, 0.5, 0.75, 1] as $ring)
                        <circle cx="130" cy="130" r="{{ 22 + $ring * 96 }}" fill="none" style="stroke: var(--border-glass);" stroke-width="1"/>
                    @endforeach
                    @foreach ($axisLines as $a)
                        <line x1="130" y1="130" x2="{{ $a['x2'] }}" y2="{{ $a['y2'] }}" style="stroke: var(--border-glass);" stroke-width="1"/>
                    @endforeach

                    <polygon points="{{ $radarPath }}" fill="url(#radarFill)" stroke="#7FA98D" stroke-width="2"
                             style="filter: drop-shadow(0 0 8px rgba(127,169,141,0.5)); transform-origin: 130px 130px;
                                    transform: scale(0); animation: radar-grow 1s cubic-bezier(.16,1,.3,1) forwards .3s;"/>
                    <defs>
                        <radialGradient id="radarFill">
                            <stop offset="0%" stop-color="#7FA98D" stop-opacity="0.35"/>
                            <stop offset="100%" stop-color="#8B7FD1" stop-opacity="0.08"/>
                        </radialGradient>
                    </defs>

                    @foreach ($axisLines as $a)
                        <circle cx="{{ $a['x2'] }}" cy="{{ $a['y2'] }}" r="3" fill="{{ $a['color'] }}"/>
                        <text x="{{ $a['lx'] }}" y="{{ $a['ly'] }}" style="fill: var(--text-2);" font-size="10" font-family="IBM Plex Mono, monospace" text-anchor="middle" dominant-baseline="middle">{{ $a['label'] }}</text>
                    @endforeach
                </svg>
            </div>
        </div>
    </div>
    <style>
        @keyframes ring-fill { to { stroke-dashoffset: var(--target-offset); } }
        @keyframes radar-grow { to { transform: scale(1); } }
    </style>

    {{-- ── Bento stat grid (glass, count-up) ── --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        @php
            $stats = [
                ['label' => 'Total Konsultasi', 'value' => $totalKonsultasi, 'sub' => 'Seluruh riwayat sejak awal', 'color' => '#7FA98D', 'icon' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>'],
                ['label' => 'Hari Ini', 'value' => $konsultasiHariIni, 'sub' => 'Sejak pukul 00:00', 'color' => '#3FA796', 'icon' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>'],
                ['label' => 'Total Pengguna', 'value' => $totalUser, 'sub' => 'Akun terdaftar & tamu', 'color' => '#8B7FD1', 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>'],
            ];
        @endphp

        @foreach ($stats as $s)
            <div class="group rounded-2xl glass p-5 hover-surf transition relative overflow-hidden"
                 x-data="{ val: 0 }" x-init="let t=0; const target={{ $s['value'] }}; const iv=setInterval(()=>{ t++; val = Math.min(target, Math.round(target*t/30)); if(t>=30) clearInterval(iv); }, 16);">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] t3 font-mono uppercase tracking-wide">{{ $s['label'] }}</p>
                        <p class="font-display text-[32px] font-semibold mt-1 leading-none" x-text="val.toLocaleString('id-ID')"></p>
                    </div>
                    <span class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center" style="background: {{ $s['color'] }}22; color: {{ $s['color'] }};">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $s['icon'] !!}</svg>
                    </span>
                </div>
                <p class="text-xs t3 mt-3">{{ $s['sub'] }}</p>
                <span class="absolute -bottom-6 -right-6 w-20 h-20 rounded-full opacity-20 blur-2xl" style="background: {{ $s['color'] }};"></span>
            </div>
        @endforeach

        <div class="rounded-2xl p-5 relative overflow-hidden transition"
             style="background: {{ $totalKritis > 0 ? 'linear-gradient(135deg, rgba(232,119,90,0.14), rgba(232,119,90,0.04))' : 'var(--bg-glass)' }}; border: 1px solid {{ $totalKritis > 0 ? 'rgba(232,119,90,0.3)' : 'var(--border-glass)' }}; backdrop-filter: blur(20px);">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-mono uppercase tracking-wide" style="color: {{ $totalKritis > 0 ? '#E8775A' : 'var(--text-3)' }}">Kasus Kritis</p>
                    <p class="font-display text-[32px] font-semibold mt-1 leading-none" style="color: {{ $totalKritis > 0 ? '#E8775A' : 'white' }}">{{ number_format($totalKritis) }}</p>
                </div>
                <span class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center" style="background: {{ $totalKritis > 0 ? '#E8775A22' : 'var(--border-glass)' }}; color: {{ $totalKritis > 0 ? '#E8775A' : 'var(--text-2)' }};">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4M12 17h.01"/>
                    </svg>
                </span>
            </div>
            <p class="text-xs mt-3" style="color: {{ $totalKritis > 0 ? 'rgba(232,119,90,0.8)' : 'var(--text-3)' }}">
                {{ $totalKritis > 0 ? 'Perlu tindak lanjut segera' : 'Tidak ada kasus kritis saat ini' }}
            </p>
        </div>
    </div>

    {{-- ── Distribusi tingkat stres: spektrum mengalir + glow ── --}}
    <div class="rounded-2xl glass p-6 mb-6">
        <div class="flex items-center justify-between mb-1">
            <h2 class="font-display text-base font-semibold">Distribusi Tingkat Stres</h2>
            <span class="text-xs font-mono t3">{{ number_format($total) }} total</span>
        </div>
        <p class="text-xs t3 mb-6">Proporsi seluruh hasil konsultasi berdasarkan 5 tingkat (S00–S04)</p>

        <div class="flex w-full h-3 gap-[3px] rounded-full overflow-hidden surf-1">
            @foreach ($distribusiTingkat as $i => $tingkat)
                @php $pct = ($tingkat->konsultasi_count / $total) * 100; @endphp
                @if ($pct > 0)
                    <div
                        class="h-full transition-all ease-out"
                        style="width: 0%; background-color: {{ $tingkat->warna_hex }}; box-shadow: 0 0 10px {{ $tingkat->warna_hex }}aa; transition-duration: 800ms; transition-delay: {{ $i * 90 }}ms;"
                        x-data
                        x-init="setTimeout(() => $el.style.width = '{{ $pct }}%', 50)"
                        title="{{ $tingkat->nama }}: {{ $tingkat->konsultasi_count }} konsultasi ({{ round($pct) }}%)"
                    ></div>
                @endif
            @endforeach
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3 mt-6">
            @foreach ($distribusiTingkat as $tingkat)
                @php $pct = ($tingkat->konsultasi_count / $total) * 100; @endphp
                <div class="rounded-xl border hairline px-3 py-2.5 hover-surf transition">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $tingkat->warna_hex }}; box-shadow: 0 0 6px {{ $tingkat->warna_hex }};"></span>
                        <span class="text-xs t2 truncate">{{ $tingkat->nama }}</span>
                    </div>
                    <p class="font-mono text-sm t1 font-medium">{{ $tingkat->konsultasi_count }} <span class="t3">· {{ round($pct) }}%</span></p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ── Konsultasi terbaru: kartu kaca ── --}}
    <div class="rounded-2xl glass overflow-hidden">
        <div class="px-6 py-4 border-b hairline flex items-center justify-between">
            <div>
                <h2 class="font-display text-base font-semibold">Konsultasi Terbaru</h2>
                <p class="text-xs t3 mt-0.5">{{ $konsultasiTerbaru->count() }} entri terakhir</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-0">
                <thead>
                    <tr class="text-left text-[11px] t3 font-mono uppercase tracking-wide surf-1">
                        <th class="px-6 py-3 font-medium">Responden</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Tingkat</th>
                        <th class="px-6 py-3 font-medium">CF</th>
                        <th class="px-6 py-3 font-medium text-right">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($konsultasiTerbaru as $k)
                        <tr class="group transition hover-surf {{ $k->is_kritis ? 'bg-[#E8775A]/[0.05]' : '' }}">
                            <td class="px-6 py-3.5 border-t hairline">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 shrink-0 rounded-full text-xs font-semibold flex items-center justify-center font-mono"
                                          style="background: linear-gradient(135deg, rgba(127,169,141,0.25), rgba(139,127,209,0.25)); box-shadow: inset 0 0 0 1px var(--border-glass);">
                                        {{ strtoupper(substr($k->nama_responden, 0, 1)) }}
                                    </span>
                                    <span class="t1 font-medium">{{ $k->nama_responden }}</span>
                                    @if ($k->is_kritis)
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#E8775A]" style="box-shadow: 0 0 6px #E8775A;"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline">
                                @if ($k->user)
                                    <span class="inline-flex items-center gap-1.5 text-xs t2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sage-400"></span>
                                        Terdaftar ({{ $k->user->name }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs t3">
                                        <span class="w-1.5 h-1.5 rounded-full surf-2"></span>
                                        Tamu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 border-t hairline"><x-badge-tingkat :tingkat="$k->tingkatStres" /></td>
                            <td class="px-6 py-3.5 border-t hairline">
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-1.5 rounded-full surf-2 overflow-hidden">
                                        <div class="h-full rounded-full" style="width: {{ $k->cf_persen }}%; background: linear-gradient(90deg, #7FA98D, #3FA796);"></div>
                                    </div>
                                    <span class="font-mono t2 text-xs">{{ $k->cf_persen }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline t3 text-xs text-right" title="{{ $k->created_at->translatedFormat('d M Y, H:i') }}">
                                {{ $k->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center border-t hairline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 mx-auto t3 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                                <p class="t3 text-sm">Belum ada data konsultasi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.admin>