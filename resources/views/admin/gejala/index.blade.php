<x-layouts.admin title="Gejala">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display text-2xl font-semibold t1">Data Gejala</h1>
            <p class="t2 mt-1 text-sm">Kelola gejala dan nilai CF pakar yang digunakan dalam perhitungan konsultasi.</p>
        </div>
        <a href="{{ route('admin.gejala.create') }}"
           class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
           style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Gejala
        </a>
    </div>

    <div class="rounded-2xl glass overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-0">
                <thead>
                    <tr class="text-left text-[11px] t3 font-mono uppercase tracking-wide surf-1">
                        <th class="px-6 py-3 font-medium">Kode</th>
                        <th class="px-6 py-3 font-medium">Nama Gejala</th>
                        <th class="px-6 py-3 font-medium">Kategori</th>
                        <th class="px-6 py-3 font-medium">CF Pakar</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gejala as $g)
                        <tr class="group transition hover-surf">
                            <td class="px-6 py-3.5 border-t hairline">
                                <span class="font-mono text-xs t1 font-semibold">{{ $g->kode }}</span>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline">
                                <p class="t1 font-medium">{{ $g->nama_gejala }}</p>
                                @if ($g->deskripsi)
                                    <p class="text-xs t3 mt-0.5 truncate max-w-xs">{{ $g->deskripsi }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 border-t hairline">
                                <span class="inline-flex items-center text-xs t2 px-2.5 py-1 rounded-full surf-2 capitalize">
                                    {{ $g->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline">
                                <div class="flex items-center gap-2">
                                    <div class="w-14 h-1.5 rounded-full surf-2 overflow-hidden">
                                        <div class="h-full rounded-full" style="width: {{ $g->cf_pakar * 100 }}%; background: linear-gradient(90deg, #7FA98D, #3FA796);"></div>
                                    </div>
                                    <span class="font-mono t2 text-xs">{{ number_format($g->cf_pakar * 100, 0) }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline">
                                <form method="POST" action="{{ route('admin.gejala.toggle-active', $g) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full transition hover:opacity-80"
                                            style="background: {{ $g->is_active ? 'rgba(127,169,141,0.14)' : 'var(--border-glass)' }}; color: {{ $g->is_active ? '#7FA98D' : 'var(--text-3)' }};">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $g->is_active ? '#7FA98D' : 'var(--text-3)' }};"></span>
                                        {{ $g->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.gejala.edit', $g) }}" class="t2 hover:opacity-70 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.gejala.destroy', $g) }}"
                                          onsubmit="return confirm('Hapus gejala &quot;{{ $g->nama_gejala }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="t3 hover:text-[#E8775A] transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center border-t hairline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 mx-auto t3 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 12h6m-6 4h6M9 8h1M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14l-4-3-4 3-4-3-4 3V6z"/>
                                </svg>
                                <p class="t3 text-sm mb-4">Belum ada data gejala.</p>
                                <a href="{{ route('admin.gejala.create') }}" class="text-sm font-medium" style="color: #7FA98D;">
                                    + Tambah gejala pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($gejala->hasPages())
            <div class="px-6 py-4 border-t hairline">
                {{ $gejala->links() }}
            </div>
        @endif
    </div>

</x-layouts.admin>