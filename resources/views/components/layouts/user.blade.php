<x-layouts.app :title="$title ?? 'Dashboard'">

    <div
        x-data="{ mobileNavOpen: false }"
        class="min-h-screen relative overflow-hidden flex flex-col transition-colors duration-300"
        style="background: var(--bg-page); color: var(--text-1);"
    >

        {{-- Aurora field — identik dengan shell admin, motif napas yang konsisten lintas role --}}
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

            /* Underline aktif yang halus di nav desktop, tanpa nambah warna baru */
            .nav-link { position: relative; padding-bottom: 2px; }
            .nav-link::after {
                content: '';
                position: absolute; left: 0; right: 0; bottom: -4px; height: 2px;
                background: linear-gradient(135deg, #7FA98D, #3FA796);
                border-radius: 9999px;
                transform: scaleX(0); transform-origin: left;
                transition: transform .25s ease;
            }
            .nav-link:hover::after,
            .nav-link[data-active="true"]::after { transform: scaleX(1); }

            .icon-btn { transition: transform .18s ease, background-color .18s ease; }
            .icon-btn:hover { transform: translateY(-1px); background: var(--bg-glass-hover); }
            .icon-btn:active { transform: translateY(0) scale(.95); }

            .logo-mark { transition: transform .25s ease; }
            a:hover .logo-mark { transform: scale(1.06) rotate(-4deg); }
        </style>

        <nav class="glass border-b sticky top-0 z-30" style="border-color: var(--border-glass);">
            <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">

                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                    <span class="logo-mark w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #7FA98D, #3FA796);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 text-[#0a1110]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12h4l2 7 4-14 2 7h6"/>
                        </svg>
                    </span>
                    <span class="font-display text-xl font-semibold t1">CalmAcad</span>
                </a>

                {{-- Nav desktop --}}
                <div class="hidden sm:flex items-center gap-6 text-sm">
                    <a href="{{ route('user.dashboard') }}"
                       data-active="{{ request()->routeIs('user.dashboard') ? 'true' : 'false' }}"
                       class="nav-link transition"
                       style="color: {{ request()->routeIs('user.dashboard') ? 'var(--text-1)' : 'var(--text-2)' }}; font-weight: {{ request()->routeIs('user.dashboard') ? '500' : '400' }};">
                        Dashboard
                    </a>
                    <a href="{{ route('konsultasi.index') }}"
                       data-active="{{ request()->routeIs('konsultasi.*') ? 'true' : 'false' }}"
                       class="nav-link transition"
                       style="color: {{ request()->routeIs('konsultasi.*') ? 'var(--text-1)' : 'var(--text-2)' }}; font-weight: {{ request()->routeIs('konsultasi.*') ? '500' : '400' }};">
                        Konsultasi Baru
                    </a>
                    <a href="{{ route('user.riwayat') }}"
                       data-active="{{ request()->routeIs('user.riwayat*') ? 'true' : 'false' }}"
                       class="nav-link transition"
                       style="color: {{ request()->routeIs('user.riwayat*') ? 'var(--text-1)' : 'var(--text-2)' }}; font-weight: {{ request()->routeIs('user.riwayat*') ? '500' : '400' }};">
                        Riwayat
                    </a>
                </div>

                <div class="flex items-center gap-3 sm:gap-5 text-sm">

                    {{-- Sakelar siang / malam --}}
                    <div class="hidden xs:flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 t3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                        <button type="button" class="theme-switch" role="switch" :aria-checked="night" @click="night = !night" aria-label="Ganti mode siang / malam">
                            <span class="knob"></span>
                        </button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 t3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    </div>

                    <a href="{{ route('user.notif.index') }}" class="icon-btn relative t2 w-9 h-9 rounded-full flex items-center justify-center" aria-label="Notifikasi">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />
                        </svg>
                        @if(($notifBelumDibaca ?? 0) > 0)
                            <span class="absolute top-1 right-1 w-4 h-4 rounded-full text-white text-[10px] leading-4 text-center" style="background: #E8775A; box-shadow: 0 0 6px #E8775A;">
                                {{ $notifBelumDibaca }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('user.profile.edit') }}" class="hidden sm:inline t2 hover:opacity-80 transition">Profil</a>

                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit" class="t2 hover:text-[#E8775A] transition">Keluar</button>
                    </form>

                    {{-- Tombol hamburger — hanya muncul di mobile --}}
                    <button type="button"
                            class="icon-btn sm:hidden w-9 h-9 rounded-full flex items-center justify-center t1"
                            @click="mobileNavOpen = !mobileNavOpen"
                            :aria-expanded="mobileNavOpen"
                            aria-label="Buka menu">
                        <svg x-show="!mobileNavOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                        <svg x-show="mobileNavOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Panel nav mobile --}}
            <div x-show="mobileNavOpen"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-end="opacity-0"
                 @click.outside="mobileNavOpen = false"
                 class="sm:hidden border-t px-6 py-4 space-y-1"
                 style="border-color: var(--border-glass);">
                <a href="{{ route('user.dashboard') }}" class="block rounded-xl px-3 py-2.5 text-sm hover-surf transition" style="color: {{ request()->routeIs('user.dashboard') ? 'var(--text-1)' : 'var(--text-2)' }}; font-weight: {{ request()->routeIs('user.dashboard') ? '500' : '400' }};">Dashboard</a>
                <a href="{{ route('konsultasi.index') }}" class="block rounded-xl px-3 py-2.5 text-sm hover-surf transition" style="color: {{ request()->routeIs('konsultasi.*') ? 'var(--text-1)' : 'var(--text-2)' }}; font-weight: {{ request()->routeIs('konsultasi.*') ? '500' : '400' }};">Konsultasi Baru</a>
                <a href="{{ route('user.riwayat') }}" class="block rounded-xl px-3 py-2.5 text-sm hover-surf transition" style="color: {{ request()->routeIs('user.riwayat*') ? 'var(--text-1)' : 'var(--text-2)' }}; font-weight: {{ request()->routeIs('user.riwayat*') ? '500' : '400' }};">Riwayat</a>
                <a href="{{ route('user.profile.edit') }}" class="block rounded-xl px-3 py-2.5 text-sm hover-surf transition t2">Profil</a>
                <div class="flex items-center justify-between rounded-xl px-3 py-2.5">
                    <span class="text-sm t2">Mode malam</span>
                    <button type="button" class="theme-switch" role="switch" :aria-checked="night" @click="night = !night" aria-label="Ganti mode siang / malam">
                        <span class="knob"></span>
                    </button>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left rounded-xl px-3 py-2.5 text-sm hover-surf transition" style="color: #E8775A;">Keluar</button>
                </form>
            </div>
        </nav>

        <main class="relative z-10 flex-1 max-w-5xl w-full mx-auto px-6 py-10">
            {{ $slot }}
        </main>

        <footer class="relative z-10 text-center text-xs t3 py-8">
            CalmAcad — "Kenali stresmu, pulihkan dirimu"
        </footer>
    </div>

</x-layouts.app>