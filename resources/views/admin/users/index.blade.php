<x-layouts.admin title="Pengguna">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-2xl font-semibold t1">Pengguna</h1>
            <p class="t2 mt-1 text-sm">Kelola akun pengguna yang terdaftar di CalmAcad.</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90 shrink-0"
           style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Pengguna
        </a>
    </div>

    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
        <div class="relative max-w-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 t3 absolute left-3.5 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau email..."
                   class="w-full rounded-full pl-10 pr-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                   style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        </div>
    </form>

    <div class="rounded-2xl glass overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-0">
                <thead>
                    <tr class="text-left text-[11px] t3 font-mono uppercase tracking-wide surf-1">
                        <th class="px-6 py-3 font-medium">Pengguna</th>
                        <th class="px-6 py-3 font-medium">Konsultasi</th>
                        <th class="px-6 py-3 font-medium">Bergabung</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr class="group transition hover-surf">
                            <td class="px-6 py-3.5 border-t hairline">
                                <div class="flex items-center gap-3">
                                    <span class="w-9 h-9 shrink-0 rounded-full overflow-hidden text-xs font-semibold flex items-center justify-center font-mono t1"
                                          style="background: linear-gradient(135deg, rgba(127,169,141,0.25), rgba(139,127,209,0.25)); box-shadow: inset 0 0 0 1px var(--border-glass);">
                                        @if ($u->photo)
                                            <img src="{{ Storage::url($u->photo) }}" alt="{{ $u->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        @endif
                                    </span>
                                    <div class="min-w-0">
                                        <p class="t1 font-medium truncate">{{ $u->name }}</p>
                                        <p class="text-xs t3 truncate">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline">
                                <span class="font-mono t2 text-sm">{{ $u->konsultasi_count }}</span>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline t3 text-xs" title="{{ $u->created_at->translatedFormat('d M Y, H:i') }}">
                                {{ $u->created_at->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-3.5 border-t hairline text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.users.show', $u) }}" class="t2 hover:opacity-70 transition" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $u) }}" class="t2 hover:opacity-70 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                          onsubmit="return confirm('Hapus pengguna &quot;{{ $u->name }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
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
                            <td colspan="4" class="px-6 py-16 text-center border-t hairline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 mx-auto t3 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                </svg>
                                <p class="t3 text-sm">
                                    @if (request('search'))
                                        Tidak ada pengguna yang cocok dengan pencarian "{{ request('search') }}".
                                    @else
                                        Belum ada pengguna terdaftar.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="px-6 py-4 border-t hairline">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</x-layouts.admin>