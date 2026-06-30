<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Kenali tingkat stres akademikmu lewat 25 indikator, dihitung dengan metode certainty factor. Cepat, privat, dan berbasis bukti.">
    <title>CalmAcad — Kenali stresmu, pulihkan dirimu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ─── Tema ─── */
        :root {
            --bg:          #F4F2EC;
            --bg-card:     rgba(255,255,255,0.78);
            --bg-card-h:   rgba(255,255,255,0.96);
            --border:      rgba(31,46,43,0.09);
            --border-em:   rgba(31,46,43,0.18);
            --t1:          #1C2321;
            --t2:          rgba(28,35,33,0.60);
            --t3:          rgba(28,35,33,0.38);
            --dot:         rgba(31,46,43,0.055);
            --blob-op:     0.06;
            --shadow:      0 1px 3px rgba(28,35,33,0.05), 0 8px 28px rgba(28,35,33,0.07);
            --green:       #7FA98D;
            --teal:        #3FA796;
            --accent-bg:   rgba(127,169,141,0.10);
            --accent-bg-h: rgba(127,169,141,0.17);
            color-scheme: light;
        }
        html.night {
            --bg:          #080c0b;
            --bg-card:     rgba(255,255,255,0.038);
            --bg-card-h:   rgba(255,255,255,0.065);
            --border:      rgba(255,255,255,0.085);
            --border-em:   rgba(255,255,255,0.15);
            --t1:          #f0eeea;
            --t2:          rgba(240,238,234,0.55);
            --t3:          rgba(240,238,234,0.33);
            --dot:         rgba(255,255,255,0.03);
            --blob-op:     1;
            --shadow:      0 1px 3px rgba(0,0,0,0.28), 0 10px 32px rgba(0,0,0,0.38);
            --accent-bg:   rgba(127,169,141,0.12);
            --accent-bg-h: rgba(127,169,141,0.22);
            color-scheme: dark;
        }

        /* ─── Reset & Base ─── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--t1);
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            transition: background .3s, color .3s;
        }

        /* ─── Tipografi ─── */
        .display { font-family: 'Fraunces', Georgia, serif; }
        .mono    { font-family: 'IBM Plex Mono', monospace; }
        .t1 { color: var(--t1); }
        .t2 { color: var(--t2); }
        .t3 { color: var(--t3); }

        /* ─── Glass card ─── */
        .glass {
            background: var(--bg-card);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .glass-hover { transition: background .2s; }
        .glass-hover:hover { background: var(--bg-card-h); }

        /* ─── Background ambience ─── */
        .bg-layer { pointer-events: none; position: fixed; inset: 0; z-index: 0; }
        .bg-blobs { opacity: var(--blob-op); transition: opacity .4s; }

        @keyframes drift1 { 0%,100%{transform:translate(0,0)}  50%{transform:translate(44px,56px)} }
        @keyframes drift2 { 0%,100%{transform:translate(0,0)}  50%{transform:translate(-52px,38px)} }
        @keyframes drift3 { 0%,100%{transform:translate(0,0)}  50%{transform:translate(30px,-44px)} }
        @media (prefers-reduced-motion: reduce) {
            .blob { animation: none !important; }
            .pulse::before { animation: none !important; }
        }

        .blob {
            position: absolute; border-radius: 50%; filter: blur(110px);
        }
        .blob-1 { width: 560px; height: 560px; top: -100px; left: -80px;
            background: radial-gradient(circle, #7FA98D, transparent 70%); opacity: .20;
            animation: drift1 24s ease-in-out infinite; }
        .blob-2 { width: 480px; height: 480px; top: 30%; right: -100px;
            background: radial-gradient(circle, #8B7FD1, transparent 70%); opacity: .16;
            animation: drift2 28s ease-in-out infinite; }
        .blob-3 { width: 440px; height: 440px; bottom: -60px; left: 22%;
            background: radial-gradient(circle, #3FA796, transparent 70%); opacity: .14;
            animation: drift3 32s ease-in-out infinite; }

        .bg-dots {
            background-image: radial-gradient(circle, var(--dot) 1px, transparent 1px);
            background-size: 26px 26px;
            opacity: .7;
        }

        /* ─── Live pulse ─── */
        @keyframes breathe {
            0%,100% { transform: scale(1); opacity: .5; }
            50%      { transform: scale(1.7); opacity: 0; }
        }
        .pulse { position: relative; }
        .pulse::before {
            content: ''; position: absolute; inset: 0; border-radius: 9999px;
            background: currentColor;
            animation: breathe 2.8s cubic-bezier(.4,0,.2,1) infinite;
        }

        /* ─── Nav ─── */
        nav {
            position: sticky; top: 0; z-index: 30;
            border-bottom: 1px solid var(--border);
        }
        .nav-inner {
            max-width: 1024px; margin: auto; padding: 0 1.5rem;
            height: 60px; display: flex; align-items: center; justify-content: space-between;
        }
        .logo { display: flex; align-items: center; gap: .625rem; text-decoration: none; }
        .logo-icon {
            width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--green), var(--teal));
        }
        .logo-icon svg { width: 16px; height: 16px; }
        .logo-text { font-family: 'Fraunces', serif; font-size: 1.2rem; font-weight: 600; color: var(--t1); }

        /* ─── Theme toggle ─── */
        .toggle-wrap { display: flex; align-items: center; gap: .5rem; }
        .toggle-wrap svg { width: 14px; height: 14px; color: var(--t3); }
        .toggle {
            width: 42px; height: 23px; border-radius: 9999px; flex-shrink: 0;
            background: var(--border); border: 1px solid var(--border-em);
            position: relative; cursor: pointer; transition: background .3s;
        }
        .toggle .knob {
            position: absolute; top: 2px; left: 2px;
            width: 17px; height: 17px; border-radius: 9999px;
            background: linear-gradient(135deg, var(--green), var(--teal));
            transition: transform .3s cubic-bezier(.4,0,.2,1);
        }
        html.night .toggle .knob { transform: translateX(19px); }

        /* ─── Buttons ─── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 9999px; font-size: .875rem; font-weight: 500;
            padding: .625rem 1.5rem; text-decoration: none; transition: opacity .18s, transform .18s;
            white-space: nowrap; cursor: pointer; border: none;
        }
        .btn:hover { opacity: .88; transform: translateY(-1px); }
        .btn:active { transform: scale(.98); }
        .btn-primary {
            color: #fff;
            background: linear-gradient(135deg, var(--green), var(--teal));
            box-shadow: 0 4px 18px rgba(127,169,141,.32);
        }
        .btn-ghost {
            background: var(--bg-card); color: var(--t1);
            border: 1px solid var(--border-em);
        }
        html.night .btn-ghost { background: var(--bg-card); }
        .btn-ghost:hover { background: var(--bg-card-h); }
        .btn-text { background: none; padding: .5rem .75rem; color: var(--t2); }
        .btn-text:hover { color: var(--t1); opacity: 1; }

        /* ─── Nav buttons ─── */
        .nav-cta { font-size: .8rem; padding: .45rem 1.1rem; }

        /* ─── Layout ─── */
        .content { position: relative; z-index: 10; flex: 1; }
        .wrap { max-width: 1024px; margin: auto; padding: 0 1.5rem; }

        /* ─── Hero ─── */
        .hero { padding: 5rem 0 3.5rem; text-align: center; }
        .badge {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .375rem .875rem; border-radius: 9999px;
            font-size: .7rem; font-weight: 500; letter-spacing: .06em; text-transform: uppercase;
            margin-bottom: 1.75rem; color: var(--t2);
        }
        .badge-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green); flex-shrink: 0; }
        .hero-h1 {
            font-family: 'Fraunces', serif; font-size: clamp(2.2rem, 5vw, 3.4rem);
            font-weight: 600; line-height: 1.15; color: var(--t1);
            max-width: 660px; margin: 0 auto .375rem;
        }
        .hero-h1 em { font-style: italic; color: var(--green); }
        .hero-sub {
            font-size: clamp(.9rem, 2vw, 1.05rem); color: var(--t2);
            max-width: 520px; margin: 1.1rem auto 0; line-height: 1.75;
        }
        .hero-actions {
            display: flex; flex-wrap: wrap; align-items: center; justify-content: center;
            gap: .75rem; margin-top: 2.25rem;
        }
        .hero-note { font-family: 'IBM Plex Mono', monospace; font-size: .68rem; color: var(--t3); margin-top: .875rem; }

        /* ─── Stats strip ─── */
        .stats-strip {
            display: flex; flex-wrap: wrap; justify-content: center; gap: .5rem;
            margin: 3rem 0;
        }
        .stat-pill {
            display: flex; align-items: center; gap: .5rem;
            padding: .5rem 1rem; border-radius: 9999px; font-size: .8rem; color: var(--t2);
        }
        .stat-pill svg { width: 14px; height: 14px; color: var(--green); flex-shrink: 0; }

        /* ─── How it works ─── */
        .section { padding: 1.5rem 0 4rem; }
        .section-label {
            display: block; text-align: center;
            font-family: 'IBM Plex Mono', monospace; font-size: .7rem; color: var(--t3);
            text-transform: uppercase; letter-spacing: .09em; margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Fraunces', serif; font-size: clamp(1.35rem, 3vw, 1.9rem);
            font-weight: 600; color: var(--t1); text-align: center; margin-bottom: 2.75rem;
        }

        .steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1px; }
        .steps-wrap {
            border-radius: 1.25rem; overflow: hidden;
            border: 1px solid var(--border); background: var(--border);
        }
        .step {
            background: var(--bg-card); padding: 2rem 1.75rem;
            display: flex; flex-direction: column; gap: .75rem;
            backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px);
        }
        .step-num {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: var(--accent-bg); color: var(--green);
            font-family: 'IBM Plex Mono', monospace; font-size: .8rem; font-weight: 500;
            flex-shrink: 0;
        }
        .step-title { font-size: .9rem; font-weight: 600; color: var(--t1); }
        .step-desc  { font-size: .82rem; color: var(--t2); line-height: 1.65; }

        /* ─── Info banner ─── */
        .info-banner {
            border-radius: 1rem; padding: 1.25rem 1.5rem;
            display: flex; gap: 1rem; align-items: flex-start;
            background: rgba(63,167,150,0.07);
            border: 1px solid rgba(63,167,150,0.22);
            margin-bottom: 4rem;
        }
        .info-banner svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
        .info-title { font-size: .875rem; font-weight: 600; color: var(--t1); margin-bottom: .25rem; }
        .info-desc  { font-size: .82rem; color: var(--t2); line-height: 1.65; }

        /* ─── Footer ─── */
        footer {
            position: relative; z-index: 10; text-align: center;
            padding: 1.75rem 1.5rem; font-size: .75rem; color: var(--t3);
            border-top: 1px solid var(--border); font-family: 'IBM Plex Mono', monospace;
        }

        /* ─── Responsive ─── */
        @media (max-width: 640px) {
            .hero { padding: 3.5rem 0 2.5rem; }
            .nav-login { display: none; }
            .toggle-wrap { display: none; }
            .mobile-toggle {
                display: flex; align-items: center; gap: .4rem;
            }
            .stats-strip { gap: .35rem; }
            .stat-pill { font-size: .75rem; padding: .4rem .75rem; }
            .hero-actions { flex-direction: column; width: 100%; }
            .hero-actions .btn { width: 100%; }
        }
        @media (min-width: 641px) {
            .mobile-toggle { display: none; }
        }

        [x-cloak] { display: none !important; }
    </style>

    <script>
        (function () {
            var saved = localStorage.getItem('calmacad-theme');
            var dark = saved ? saved === 'night' : true;
            document.documentElement.classList.toggle('night', dark);
        })();
    </script>
</head>

<body
    x-data="{ night: document.documentElement.classList.contains('night') }"
    x-init="$watch('night', v => {
        document.documentElement.classList.toggle('night', v);
        localStorage.setItem('calmacad-theme', v ? 'night' : 'day');
    })"
>
    {{-- ── Background ── --}}
    <div class="bg-layer bg-blobs" aria-hidden="true">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>
    <div class="bg-layer bg-dots" aria-hidden="true"></div>

    {{-- ── Nav ── --}}
    <nav class="glass">
        <div class="nav-inner">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="logo" aria-label="CalmAcad — beranda">
                <span class="logo-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#0a1110" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 12h4l2 7 4-14 2 7h6"/>
                    </svg>
                </span>
                <span class="logo-text">CalmAcad</span>
            </a>

            {{-- Right side --}}
            <div style="display:flex; align-items:center; gap:.75rem;">

                {{-- Theme toggle — desktop --}}
                <div class="toggle-wrap" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                    <button
                        type="button" class="toggle" role="switch"
                        :aria-checked="night" @click="night = !night"
                        aria-label="Ganti mode siang atau malam">
                        <span class="knob"></span>
                    </button>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </div>

                {{-- Theme toggle — mobile only --}}
                <button
                    type="button" class="mobile-toggle btn btn-ghost" style="padding:.45rem .7rem; gap:.3rem; font-size:.75rem;"
                    @click="night = !night" :aria-label="night ? 'Mode siang' : 'Mode malam'">
                    <svg x-show="night" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                    <svg x-show="!night" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>

                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary nav-cta">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-text nav-login">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary nav-cta">Daftar gratis</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    {{-- ── Main ── --}}
    <main class="content">
        <div class="wrap">

            {{-- Hero --}}
            <section class="hero" aria-labelledby="hero-heading">

                <div class="badge glass">
                    <span class="badge-dot pulse" style="color: var(--green);" aria-hidden="true"></span>
                    <span class="mono">Sistem pakar · certainty factor</span>
                </div>

                <h1 class="hero-h1" id="hero-heading">
                    Kenali stresmu,<br><em>pulihkan</em> dirimu
                </h1>

                <p class="hero-sub">
                    25 indikator gejala, satu sesi singkat. CalmAcad menghitung tingkat stres akademikmu secara instan — privat, terukur, tanpa tebak-tebakan.
                </p>

                <div class="hero-actions">
                    @if (session('guest_has_consulted'))
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Buat akun untuk konsultasi lagi
                        </a>
                        <a href="{{ route('konsultasi.hasil.guest', session('guest_token')) }}" class="btn btn-ghost">
                            Lihat hasil cekmu
                        </a>
                    @else
                        <a href="{{ route('konsultasi.index') }}" class="btn btn-primary">
                            Cek sekarang — gratis, tanpa daftar
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-ghost">
                                Buat akun
                            </a>
                        @endif
                    @endif
                </div>

                <p class="hero-note" aria-live="polite">
                    @if (session('guest_has_consulted'))
                        Jatah cek gratismu sudah terpakai untuk sesi ini.
                    @else
                        1× percobaan gratis · hasil instan · tanpa kartu kredit
                    @endif
                </p>
            </section>

            {{-- Stats strip --}}
            <div class="stats-strip" role="list" aria-label="Keunggulan CalmAcad">
                @php
                    $stats = [
                        ['icon' => '<path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/>', 'text' => '25 indikator tervalidasi'],
                        ['icon' => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>', 'text' => 'Data kamu privat'],
                        ['icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>', 'text' => 'Hasil kurang dari 2 menit'],
                        ['icon' => '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>', 'text' => 'Metode certainty factor'],
                    ];
                @endphp
                @foreach ($stats as $s)
                    <div class="stat-pill glass" role="listitem">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $s['icon'] !!}</svg>
                        {{ $s['text'] }}
                    </div>
                @endforeach
            </div>

            {{-- How it works --}}
            <section class="section" aria-labelledby="how-heading">
                <span class="section-label mono">Cara kerjanya</span>
                <h2 class="section-title" id="how-heading">Tiga langkah, hasil nyata</h2>

                <div class="steps-wrap">
                    <div class="steps">
                        @php
                            $steps = [
                                [
                                    'n' => '01',
                                    't' => 'Isi 25 indikator',
                                    'd' => 'Jawab seberapa sering kamu mengalami tiap gejala — mulai dari tidak pernah hingga selalu. Tidak ada jawaban benar atau salah.',
                                ],
                                [
                                    'n' => '02',
                                    't' => 'Dihitung otomatis',
                                    'd' => 'Sistem memetakan jawabanmu ke model certainty factor dan menghitung indeks stres akademik secara real-time.',
                                ],
                                [
                                    'n' => '03',
                                    't' => 'Baca hasilnya',
                                    'd' => 'Indeks dan tingkat stres muncul seketika. Pengguna terdaftar mendapat rekomendasi penanganan dan pengingat berkala.',
                                ],
                            ];
                        @endphp
                        @foreach ($steps as $s)
                            <div class="step">
                                <div class="step-num" aria-hidden="true">{{ $s['n'] }}</div>
                                <h3 class="step-title">{{ $s['t'] }}</h3>
                                <p class="step-desc">{{ $s['d'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Guest limit notice --}}
            <div class="info-banner" role="note" aria-label="Batas cek gratis">
                <svg viewBox="0 0 24 24" fill="none" stroke="#3FA796" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                </svg>
                <div>
                    <p class="info-title">Cek gratis dibatasi satu kali per sesi</p>
                    <p class="info-desc">
                        Tanpa akun, kamu hanya melihat hasil tingkat stres — tanpa rekomendasi penanganan atau pengingat berkala.
                        Daftar gratis untuk riwayat lengkap, rekomendasi personal, dan notifikasi otomatis.
                    </p>
                </div>
            </div>

        </div>{{-- /wrap --}}
    </main>

    <footer>
        CalmAcad &mdash; &ldquo;Kenali stresmu, pulihkan dirimu&rdquo;
    </footer>
</body>
</html>