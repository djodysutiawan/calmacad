{{--
    resources/views/user/notification/index.blade.php

    Diterima dari User\NotificationController@index:
    - $notifikasi (LengthAwarePaginator|Collection, berisi judul, pesan, dibaca_at|is_read, created_at)
--}}
<x-layouts.user title="Notifikasi">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display text-2xl font-semibold t1">Notifikasi</h1>
            <p class="t2 mt-1 text-sm">Pembaruan dan pengingat seputar konsultasimu.</p>
        </div>
    </div>

    @if ($notifikasi->isEmpty())
        <div class="rounded-2xl glass p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto t3 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />
            </svg>
            <p class="t2 text-sm">Belum ada notifikasi untukmu.</p>
        </div>
    @else
        <div class="rounded-2xl glass overflow-hidden divide-y" style="border-color: var(--border-glass);">
            @foreach ($notifikasi as $n)
                @php $isRead = $n->dibaca_at ?? $n->is_read ?? $n->read_at ?? false; @endphp
                <div class="flex items-start gap-4 px-6 py-4 hover-surf transition" style="border-color: var(--border-glass);">
                    <span class="mt-1.5 w-2 h-2 rounded-full shrink-0"
                          style="background: {{ $isRead ? 'transparent' : '#7FA98D' }}; box-shadow: {{ $isRead ? 'none' : '0 0 6px #7FA98D' }};"></span>
                    <div class="min-w-0 flex-1">
                        <p class="t1 text-sm {{ $isRead ? 'font-normal' : 'font-medium' }}">{{ $n->judul ?? 'Pemberitahuan' }}</p>
                        <p class="t2 text-sm mt-0.5">{{ $n->pesan ?? $n->message }}</p>
                        <p class="text-xs t3 mt-1.5" title="{{ $n->created_at->translatedFormat('d M Y, H:i') }}">
                            {{ $n->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        @if (method_exists($notifikasi, 'hasPages') && $notifikasi->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $notifikasi->links() }}
            </div>
        @endif
    @endif

</x-layouts.user>