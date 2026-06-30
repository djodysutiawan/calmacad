<x-layouts.admin title="Detail Pengguna">

    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-sm t2 hover:opacity-80 mb-6 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        Kembali ke Pengguna
    </a>

    <div class="rounded-2xl glass p-7 mb-6 flex flex-col sm:flex-row sm:items-center gap-6">
        <span class="w-16 h-16 shrink-0 rounded-full overflow-hidden text-xl font-semibold flex items-center justify-center font-mono t1"
              style="background: linear-gradient(135deg, rgba(127,169,141,0.25), rgba(139,127,209,0.25)); box-shadow: inset 0 0 0 1px var(--border-glass);">
            @if ($user->photo)
                <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </span>
        <div class="flex-1 min-w-0">
            <h1 class="font-display text-xl font-semibold t1">{{ $user->name }}</h1>
            <p class="text-sm t2 mt-1">{{ $user->email }}</p>
            <p class="text-xs t3 mt-2">Bergabung {{ $user->created_at->translatedFormat('d F Y') }}</p>
        </div>
        <a href="{{ route('admin.users.edit', $user) }}"
           class="inline-flex items-center rounded-full px-5 py-2.5 text-sm font-medium t1 hover-surf transition shrink-0"
           style="border: 1px solid var(--border-glass);">
            Edit Pengguna
        </a>
    </div>

    <div class="rounded-2xl glass overflow-hidden">
        <div class="px-6 py-4 border-b hairline">
            <h2 class="font-display text-base font-semibold t1">Riwayat Konsultasi</h2>
            <p class="text-xs t3 mt-0.5">{{ $user->konsultasi->count() }} entri</p>
        </div>

        @if ($user->konsultasi->isEmpty())
            <div class="px-6 py-16 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 mx-auto t3 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <p class="t3 text-sm">Pengguna ini belum pernah konsultasi.</p>
            </div>
        @else
            <div class="divide-y" style="border-color: var(--border-glass);">
                @foreach ($user->konsultasi as $k)
                    <div class="flex items-center justify-between gap-4 px-6 py-4">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-mono text-xs font-semibold"
                                 style="background: {{ $k->tingkatStres->warna_hex }}1f; color: {{ $k->tingkatStres->warna_hex }};">
                                {{ number_format($k->cf_persen, 0) }}%
                            </div>
                            <div class="min-w-0">
                                <p class="t1 font-medium truncate">{{ $k->tingkatStres->nama }}</p>
                                <p class="text-xs t3 mt-0.5">{{ $k->created_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>
                        <x-badge-tingkat :tingkat="$k->tingkatStres" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-layouts.admin>