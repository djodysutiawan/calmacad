
<x-layouts.user title="Hasil Konsultasi">

    <div class="max-w-2xl mx-auto">

        {{-- ── Flash info (mis. "kamu sudah pakai jatah gratis") ── --}}
        @if (session('info'))
            <div class="rounded-xl mb-6 px-4 py-3.5 text-sm" style="background: rgba(63,167,150,0.1); border: 1px solid rgba(63,167,150,0.3); color: #3FA796;">
                {{ session('info') }}
            </div>
        @endif

        {{-- ── Header ── --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl mb-5"
                 style="background: {{ $konsultasi->is_kritis ? 'rgba(232,119,90,0.12)' : 'rgba(127,169,141,0.12)' }};">
                @if ($konsultasi->is_kritis)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#E8775A" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 9v4M12 17h.01M10.29 3.86l-8.18 14.18A2 2 0 0 0 3.82 21h16.36a2 2 0 0 0 1.71-2.96L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#7FA98D" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 21c-4.97 0-9-3.694-9-8.25 0-1.94.752-3.722 2.003-5.13C6.367 5.62 9.039 4.5 12 4.5s5.633 1.12 6.997 3.12C20.248 9.028 21 10.81 21 12.75 21 17.306 16.97 21 12 21z"/>
                        <path d="M9 11.25h.008M15 11.25h.008M9.5 15.5c.75.667 1.75 1 2.5 1s1.75-.333 2.5-1"/>
                    </svg>
                @endif
            </div>
            <h1 class="font-display text-2xl sm:text-3xl font-semibold t1">Hasil Konsultasi</h1>
            <p class="text-sm t2 mt-3 max-w-md mx-auto leading-relaxed">
                Halo, <span class="t1 font-medium">{{ $konsultasi->nama }}</span> — berikut hasil analisis tingkat stresmu.
            </p>
        </div>

        {{-- ── Card hasil ── --}}
        <div class="rounded-2xl glass overflow-hidden p-6 sm:p-8">

            {{-- Badge tingkat stres --}}
            <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold"
                      style="{{ $konsultasi->is_kritis
                          ? 'background: rgba(232,119,90,0.12); color: #E8775A;'
                          : 'background: rgba(127,169,141,0.14); color: #3FA796;' }}">
                    <span class="w-1.5 h-1.5 rounded-full" style="background: currentColor;"></span>
                    {{ $konsultasi->tingkatStres->nama_tingkat ?? 'Tingkat stres tidak diketahui' }}
                </span>

                <span class="text-[10px] font-mono uppercase tracking-wider t3">
                    {{ $konsultasi->created_at->translatedFormat('d M Y, H:i') }}
                </span>
            </div>

            {{-- Skor CF --}}
            @if (isset($konsultasi->cf_value))
                <div class="mb-6">
                    <div class="flex items-center justify-between text-xs t3 font-mono uppercase tracking-wide mb-2">
                        <span>Skor Keyakinan (CF)</span>
                        <span>{{ round($konsultasi->cf_value * 100) }}%</span>
                    </div>
                    <div class="h-1.5 rounded-full overflow-hidden" style="background: var(--bg-glass-hover);">
                        <div class="h-full rounded-full transition-all duration-500 ease-out"
                             style="width: {{ round($konsultasi->cf_value * 100) }}%; background: linear-gradient(135deg, {{ $konsultasi->is_kritis ? '#E8775A, #E8775A' : '#7FA98D, #3FA796' }});"></div>
                    </div>
                </div>
            @endif

            {{-- Deskripsi --}}
            @if ($konsultasi->tingkatStres?->deskripsi)
                <div class="mb-6 pb-6" style="border-bottom: 1px solid var(--border-glass);">
                    <h2 class="text-[10px] font-mono uppercase tracking-wider t3 mb-2">Penjelasan</h2>
                    <p class="text-sm t2 leading-relaxed">
                        {{ $konsultasi->tingkatStres->deskripsi }}
                    </p>
                </div>
            @endif

            {{-- Info tambahan --}}
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-[10px] font-mono uppercase tracking-wider t3 mb-1">Jenis Kelamin</p>
                    <p class="t1 font-medium">{{ $konsultasi->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                @if ($konsultasi->status_akademik)
                    <div>
                        <p class="text-[10px] font-mono uppercase tracking-wider t3 mb-1">Status Akademik</p>
                        <p class="t1 font-medium">{{ $konsultasi->status_akademik }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Peringatan kritis ── --}}
        @if ($konsultasi->is_kritis)
            <div class="rounded-2xl mt-5 px-5 py-4 text-sm flex items-start gap-3"
                 style="background: rgba(232,119,90,0.08); border: 1px solid rgba(232,119,90,0.25); color: #E8775A;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 9v4M12 17h.01M10.29 3.86l-8.18 14.18A2 2 0 0 0 3.82 21h16.36a2 2 0 0 0 1.71-2.96L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                </svg>
                <p class="leading-relaxed">
                    Hasil menunjukkan tingkat stres yang cukup tinggi. Sangat disarankan untuk berbicara dengan konselor, psikolog, atau orang terdekat yang kamu percaya.
                </p>
            </div>
        @endif

        {{-- ── Ajakan daftar untuk rekomendasi lengkap ── --}}
        <div class="rounded-2xl mt-5 p-6 text-center glass">
            <p class="text-sm t2 mb-4 leading-relaxed">
                Buat akun untuk melihat rekomendasi tindak lanjut, playlist penenang, dan menyimpan riwayat konsultasimu.
            </p>
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center gap-2 rounded-full px-6 py-3 text-sm font-semibold text-white transition hover:opacity-90 active:scale-[0.99]"
               style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 8px 24px rgba(127,169,141,0.3);">
                Daftar Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </a>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-xs t3 hover-surf underline underline-offset-4">
                Kembali ke Beranda
            </a>
        </div>

    </div>

</x-layouts.user>