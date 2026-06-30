
<x-layouts.user title="Riwayat Konsultasi">

    <div x-data="{ q: '' }">

        <div class="flex items-start sm:items-center justify-between gap-4 mb-6 flex-wrap">
            <div>
                <h1 class="font-display text-2xl font-semibold t1">Riwayat Konsultasi</h1>
                <p class="t2 mt-1 text-sm">Semua hasil konsultasi yang pernah kamu lakukan, terbaru di atas.</p>
            </div>
            <a href="{{ route('konsultasi.index') }}"
               class="inline-flex items-center gap-1.5 rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90 active:scale-[0.99]"
               style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                Konsultasi Baru
            </a>
        </div>

        @if ($riwayat->isEmpty())
            <div class="rounded-2xl glass p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto t3 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <p class="t2 text-sm mb-5">Kamu belum pernah konsultasi.</p>
                <a href="{{ route('konsultasi.index') }}"
                   class="inline-flex items-center rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                   style="background: linear-gradient(135deg, #7FA98D, #3FA796);">
                    Mulai Konsultasi Pertamamu
                </a>
            </div>
        @else
            {{-- ── Ringkasan singkat ── --}}
            @php
                $terakhir = $riwayat->first();
                $jumlahKritis = $riwayat->where('is_kritis', true)->count();
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                <div class="rounded-2xl glass p-4">
                    <p class="text-[10px] font-mono uppercase tracking-wide t3 mb-1">Total Konsultasi</p>
                    <p class="font-display text-xl font-semibold t1">{{ $riwayat->total() }}</p>
                </div>
                <div class="rounded-2xl glass p-4">
                    <p class="text-[10px] font-mono uppercase tracking-wide t3 mb-1">Hasil Terakhir</p>
                    <p class="font-display text-xl font-semibold truncate" style="color: {{ $terakhir->tingkatStres->warna_hex ?? 'var(--text-1)' }};">
                        {{ $terakhir->tingkatStres->nama ?? '—' }}
                    </p>
                </div>
                <div class="rounded-2xl glass p-4 col-span-2 sm:col-span-1">
                    <p class="text-[10px] font-mono uppercase tracking-wide t3 mb-1">Status Kritis</p>
                    <p class="font-display text-xl font-semibold" style="color: {{ $jumlahKritis > 0 ? '#E8775A' : 'var(--text-1)' }};">
                        {{ $jumlahKritis }} <span class="text-xs t3 font-sans font-normal">di halaman ini</span>
                    </p>
                </div>
            </div>

            {{-- ── Pencarian cepat (filter di halaman yang sedang tampil) ── --}}
            <div class="relative mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 t3 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" x-model="q" placeholder="Cari berdasarkan tingkat stres…"
                       class="w-full rounded-xl pl-11 pr-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                       style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
            </div>

            <div class="space-y-3">
                @foreach ($riwayat as $k)
                    <a href="{{ route('user.riwayat.show', $k) }}"
                       x-show="q === '' || {{ \Illuminate\Support\Js::from(\Illuminate\Support\Str::lower($k->tingkatStres->nama ?? '')) }}.includes(q.toLowerCase())"
                       x-transition:enter="transition ease-out duration-150"
                       x-transition:enter-start="opacity-0"
                       x-transition:enter-end="opacity-100"
                       class="group flex items-center justify-between gap-4 rounded-2xl glass p-5 hover-surf transition hover:-translate-y-0.5 hover:shadow-lg"
                       style="transition-property: background-color, transform, box-shadow;">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="shrink-0 w-12 h-12 rounded-full flex items-center justify-center font-display text-sm font-semibold relative"
                                 style="background: {{ $k->tingkatStres->warna_hex }}1f; color: {{ $k->tingkatStres->warna_hex }};">
                                {{ number_format($k->cf_persen, 0) }}%
                                @if ($k->is_kritis)
                                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full" style="background: #E8775A; box-shadow: 0 0 0 2px var(--bg-page);" title="Kritis"></span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="t1 font-medium truncate">{{ $k->tingkatStres->nama }}</p>
                                <p class="text-xs t3 mt-0.5" title="{{ $k->created_at->translatedFormat('d M Y, H:i') }}">
                                    {{ $k->created_at->translatedFormat('d F Y') }} · {{ $k->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <x-badge-tingkat :tingkat="$k->tingkatStres" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 t3 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($riwayat->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $riwayat->links() }}
                </div>
            @endif
        @endif
    </div>

</x-layouts.user>