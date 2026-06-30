<x-layouts.app :title="$title ?? 'Admin'">

    <div class="min-h-screen relative overflow-hidden transition-colors duration-300" style="background: var(--bg-page); color: var(--text-1);">

        {{-- Aurora field: tiga blob gradien yang melayang pelan — nyaris tak terlihat di mode siang --}}
        <div class="pointer-events-none fixed inset-0 z-0 transition-opacity duration-500" style="opacity: var(--blob-opacity);">
            <div class="absolute -top-40 -left-20 w-[600px] h-[600px] rounded-full opacity-[0.18] blur-[120px]"
                 style="background: radial-gradient(circle, #7FA98D, transparent 70%); animation: drift1 22s ease-in-out infinite;"></div>
            <div class="absolute top-1/3 -right-32 w-[520px] h-[520px] rounded-full opacity-[0.14] blur-[120px]"
                 style="background: radial-gradient(circle, #8B7FD1, transparent 70%); animation: drift2 26s ease-in-out infinite;"></div>
            <div class="absolute bottom-0 left-1/4 w-[480px] h-[480px] rounded-full opacity-[0.12] blur-[110px]"
                 style="background: radial-gradient(circle, #3FA796, transparent 70%); animation: drift3 30s ease-in-out infinite;"></div>
        </div>
        <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.6]" style="background-image: radial-gradient(circle, var(--grid-dot) 1px, transparent 1px); background-size: 28px 28px;"></div>

        <style>
            @keyframes drift1 { 0%,100%{ transform: translate(0,0) } 50%{ transform: translate(40px,60px) } }
            @keyframes drift2 { 0%,100%{ transform: translate(0,0) } 50%{ transform: translate(-50px,40px) } }
            @keyframes drift3 { 0%,100%{ transform: translate(0,0) } 50%{ transform: translate(30px,-40px) } }
            @media (prefers-reduced-motion: reduce) { [style*="drift"] { animation: none !important; } }
        </style>

        <div class="relative z-10 flex min-h-screen">

            <aside class="w-[264px] shrink-0 glass border-r flex flex-col" style="border-color: var(--border-glass);">
                <div class="px-6 h-16 flex items-center gap-2.5 border-b" style="border-color: var(--border-glass);">
                    <span class="relative w-8 h-8 rounded-full flex items-center justify-center shrink-0"
                          style="background: linear-gradient(135deg, #7FA98D, #3FA796);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 text-[#0a1110]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12h4l2 7 4-14 2 7h6"/>
                        </svg>
                    </span>
                    <div class="leading-tight">
                        <p class="font-display text-base font-semibold">CalmAcad</p>
                        <p class="text-[10px] font-mono uppercase tracking-[0.22em]" style="color: var(--text-3);">Admin Console</p>
                    </div>
                </div>

                <nav class="flex-1 px-3 py-6 space-y-1 text-sm">
                    @php
                        $navItems = [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'match' => 'admin.dashboard', 'icon' => 'grid'],
                            ['route' => 'admin.gejala.index', 'label' => 'Data Gejala', 'match' => 'admin.gejala.*', 'icon' => 'activity'],
                            ['route' => 'admin.rekomendasi.index', 'label' => 'Rekomendasi', 'match' => 'admin.rekomendasi.*', 'icon' => 'heart'],
                            ['route' => 'admin.playlist.index', 'label' => 'Playlist Musik', 'match' => 'admin.playlist.*', 'icon' => 'music'],
                            ['route' => 'admin.users.index', 'label' => 'Pengguna', 'match' => 'admin.users.*', 'icon' => 'users'],
                            ['route' => 'admin.notif.index', 'label' => 'Notifikasi', 'match' => 'admin.notif.*', 'icon' => 'bell'],
                        ];
                        $icons = [
                            'grid' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
                            'activity' => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
                            'heart' => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/>',
                            'music' => '<path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>',
                            'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
                            'bell' => '<path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9"/>',
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        @php $active = request()->routeIs($item['match']); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition relative"
                           style="color: {{ $active ? 'var(--text-1)' : 'var(--text-2)' }};">
                            @if ($active)
                                <span class="absolute inset-0 rounded-xl" style="background: linear-gradient(120deg, rgba(127,169,141,0.18), rgba(139,127,209,0.10)); box-shadow: inset 0 0 0 1px var(--border-glass);"></span>
                                <span class="absolute left-0 top-1.5 bottom-1.5 w-[3px] rounded-full" style="background: linear-gradient(180deg, #7FA98D, #3FA796); box-shadow: 0 0 12px #7FA98D;"></span>
                            @else
                                <span class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition" style="background: var(--bg-glass-hover);"></span>
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 relative"
                                 style="color: {{ $active ? '#7FA98D' : 'var(--text-3)' }};"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                {!! $icons[$item['icon']] !!}
                            </svg>
                            <span class="relative {{ $active ? 'font-medium' : '' }}">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>

                <div class="px-4 py-4 border-t space-y-3" style="border-color: var(--border-glass);">
                    <div class="flex items-center gap-2 px-2" style="color: var(--text-3);">
                        <span class="relative w-1.5 h-1.5 text-sage-400 pulse-ring">
                            <span class="absolute inset-0 rounded-full bg-sage-400"></span>
                        </span>
                        <span class="text-[10px] font-mono uppercase tracking-wider">Sistem berjalan normal</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:opacity-80" style="color: var(--text-2);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <div class="flex-1 flex flex-col min-w-0">
                <header class="h-16 glass border-b flex items-center justify-between px-8 sticky top-0 z-20" style="border-color: var(--border-glass);">
                    <h1 class="font-display text-lg font-semibold">{{ $title ?? 'Dashboard' }}</h1>
                    <div class="flex items-center gap-5">
                        {{-- Day / night switch --}}
                        <div class="flex items-center gap-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" style="color: var(--text-3);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                            <button type="button" class="theme-switch" role="switch" :aria-checked="night" @click="night = !night" aria-label="Ganti mode siang / malam">
                                <span class="knob"></span>
                            </button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" style="color: var(--text-3);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                        </div>
                        <span class="w-px h-5" style="background: var(--border-glass);"></span>
                        <span class="text-sm" style="color: var(--text-2);">{{ auth()->user()->name }}</span>
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold font-mono"
                              style="background: linear-gradient(135deg, rgba(127,169,141,0.3), rgba(139,127,209,0.3)); box-shadow: inset 0 0 0 1px var(--border-glass);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                </header>

                <main class="flex-1 px-8 py-8 overflow-x-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

</x-layouts.app>