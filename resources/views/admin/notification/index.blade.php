{{--
    resources/views/admin/notification/index.blade.php

    Diterima dari Admin\NotificationController@index:
    - $notifications (LengthAwarePaginator<Notification>, eager-load user)
    - $kritisCount (int, jumlah notifikasi tipe 'kritis' yang belum dibaca)
    - $users (Collection<User>, role=user, untuk dropdown target broadcast)

    Submit form broadcast ke Admin\NotificationController@broadcast
--}}
<x-layouts.admin title="Notifikasi">

    @php
        $statusColor = [
            'pending' => '#E0B05E',
            'sent'    => '#7FA98D',
            'failed'  => '#E8775A',
        ];
        $typeColor = [
            'kritis'  => '#E8775A',
            'reminder'=> '#3FA796',
            'info'    => '#8B7FD1',
        ];
    @endphp

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display text-2xl font-semibold t1">Notifikasi</h1>
            <p class="t2 mt-1 text-sm">Kirim notifikasi ke pengguna dan pantau riwayat pengiriman.</p>
        </div>
        @if ($kritisCount > 0)
            <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-medium"
                  style="background: rgba(232,119,90,0.12); border: 1px solid rgba(232,119,90,0.3); color: #E8775A;">
                <span class="w-1.5 h-1.5 rounded-full bg-[#E8775A]" style="box-shadow: 0 0 6px #E8775A;"></span>
                {{ $kritisCount }} notifikasi kritis belum dibaca
            </span>
        @endif
    </div>

    <div class="grid lg:grid-cols-5 gap-6 mb-6">

        {{-- ── Form broadcast ── --}}
        <div class="lg:col-span-2 rounded-2xl glass p-6 h-fit">
            <h2 class="font-display text-base font-semibold t1 mb-1">Kirim Notifikasi</h2>
            <p class="text-xs t3 mb-5">Notifikasi akan dikirim segera ke target yang dipilih.</p>

            @if ($errors->any())
                <div class="rounded-xl mb-5 px-4 py-3 text-sm" style="background: rgba(232,119,90,0.1); border: 1px solid rgba(232,119,90,0.3); color: #E8775A;">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.notif.broadcast') }}"
                  x-data="{ target: '{{ old('target', 'all') }}' }" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wide t3 mb-2">Target Penerima</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2.5 cursor-pointer rounded-xl px-3.5 py-2.5 transition hover-surf" style="border: 1px solid var(--border-glass);">
                            <input type="radio" name="target" value="all" x-model="target" class="accent-current" style="color: #7FA98D;">
                            <span class="text-sm t1">Semua pengguna</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer rounded-xl px-3.5 py-2.5 transition hover-surf" style="border: 1px solid var(--border-glass);">
                            <input type="radio" name="target" value="role" x-model="target" class="accent-current" style="color: #7FA98D;">
                            <span class="text-sm t1">Berdasarkan role</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer rounded-xl px-3.5 py-2.5 transition hover-surf" style="border: 1px solid var(--border-glass);">
                            <input type="radio" name="target" value="user" x-model="target" class="accent-current" style="color: #7FA98D;">
                            <span class="text-sm t1">Pengguna tertentu</span>
                        </label>
                    </div>
                </div>

                <div x-show="target === 'role'" x-cloak>
                    <label for="role" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Role</label>
                    <select id="role" name="role"
                            class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                            style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div x-show="target === 'user'" x-cloak>
                    <label for="user_id" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Pilih Pengguna</label>
                    <select id="user_id" name="user_id"
                            class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                            style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
                        <option value="">Pilih pengguna</option>
                        @isset($users)
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}" {{ (string) old('user_id') === (string) $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div>
                    <label for="title" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Judul</label>
                    <input id="title" name="title" type="text" maxlength="150" required
                           value="{{ old('title') }}"
                           placeholder="cth. Saatnya istirahat sejenak"
                           class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                           style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
                    @error('title')
                        <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Isi Pesan</label>
                    <textarea id="body" name="body" rows="3" required
                              placeholder="Tulis isi notifikasi..."
                              class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 resize-none"
                              style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                        style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
                    Kirim Notifikasi
                </button>
            </form>
        </div>

        {{-- ── Riwayat notifikasi ── --}}
        <div class="lg:col-span-3 rounded-2xl glass overflow-hidden">
            <div class="px-6 py-4 border-b hairline">
                <h2 class="font-display text-base font-semibold t1">Riwayat Notifikasi</h2>
                <p class="text-xs t3 mt-0.5">{{ $notifications->total() }} entri</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-separate border-spacing-0">
                    <thead>
                        <tr class="text-left text-[11px] t3 font-mono uppercase tracking-wide surf-1">
                            <th class="px-5 py-3 font-medium">Penerima</th>
                            <th class="px-5 py-3 font-medium">Notifikasi</th>
                            <th class="px-5 py-3 font-medium">Status</th>
                            <th class="px-5 py-3 font-medium text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $n)
                            <tr class="transition hover-surf">
                                <td class="px-5 py-3.5 border-t hairline">
                                    @if ($n->user)
                                        <p class="t1 font-medium text-xs">{{ $n->user->name }}</p>
                                        <p class="t3 text-[11px] mt-0.5">{{ $n->user->email }}</p>
                                    @else
                                        <span class="text-xs t3">Pengguna terhapus</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 border-t hairline">
                                    <div class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background: {{ $typeColor[$n->type] ?? 'var(--text-3)' }};"></span>
                                        <div class="min-w-0">
                                            <p class="t1 text-xs font-medium truncate max-w-[180px]">{{ $n->title }}</p>
                                            <p class="t3 text-[11px] truncate max-w-[180px]">{{ $n->body }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 border-t hairline">
                                    <span class="inline-flex items-center text-[11px] px-2 py-0.5 rounded-full capitalize"
                                          style="background: {{ $statusColor[$n->status] ?? 'var(--border-glass)' }}22; color: {{ $statusColor[$n->status] ?? 'var(--text-2)' }};">
                                        {{ $n->status }}
                                    </span>
                                    @if (is_null($n->read_at) && $n->status === 'sent')
                                        <span class="block text-[10px] t3 mt-1">belum dibaca</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 border-t hairline text-right t3 text-[11px]" title="{{ $n->created_at->translatedFormat('d M Y, H:i') }}">
                                    {{ $n->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-16 text-center border-t hairline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 mx-auto t3 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />
                                    </svg>
                                    <p class="t3 text-sm">Belum ada notifikasi yang dikirim.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($notifications->hasPages())
                <div class="px-6 py-4 border-t hairline">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>