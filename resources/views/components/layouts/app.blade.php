<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'CalmAcad' }} — Kenali stresmu, pulihkan dirimu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Set theme before first paint, avoids a light/dark flash on load --}}
    <script>
        (function () {
            var saved = localStorage.getItem('calmacad-theme');
            var isDark = saved ? saved === 'night' : true; // night is the default identity
            document.documentElement.classList.toggle('night', isDark);
        })();
    </script>

    <style>
        /* Signature motif used across admin + user shells: a slow "breathing" pulse,
           a quiet nod to the product's subject (regulating stress) rather than decoration. */
        @keyframes breathe {
            0%, 100% { transform: scale(1); opacity: .55; }
            50% { transform: scale(1.6); opacity: 0; }
        }
        .pulse-ring::before {
            content: '';
            position: absolute; inset: 0;
            border-radius: 9999px;
            background: currentColor;
            animation: breathe 2.8s cubic-bezier(.4,0,.2,1) infinite;
        }
        @media (prefers-reduced-motion: reduce) {
            .pulse-ring::before { animation: none; }
        }

        /* ── Theme tokens ──
           Day: warm cream, ink text — the original CalmAcad palette.
           Night: deep aurora-glass, the default. Toggled via .night on <html>. */
        :root {
            --bg-page: #F7F4EE;
            --bg-glass: rgba(255,255,255,0.82);
            --bg-glass-hover: rgba(255,255,255,0.95);
            --border-glass: rgba(31,46,43,0.08);
            --text-1: #1C2321;
            --text-2: rgba(28,35,33,0.62);
            --text-3: rgba(28,35,33,0.42);
            --grid-dot: rgba(31,46,43,0.05);
            --blob-opacity: 0.05;
            --shadow-soft: 0 1px 2px rgba(28,35,33,0.04), 0 8px 24px rgba(28,35,33,0.06);
            --option-bg: #ffffff;
            --option-text: #1C2321;
            color-scheme: light;
        }
        html.night {
            --bg-page: #070b0a;
            --bg-glass: rgba(255,255,255,0.035);
            --bg-glass-hover: rgba(255,255,255,0.06);
            --border-glass: rgba(255,255,255,0.08);
            --text-1: #ffffff;
            --text-2: rgba(255,255,255,0.58);
            --text-3: rgba(255,255,255,0.36);
            --grid-dot: rgba(255,255,255,0.035);
            --blob-opacity: 1;
            --shadow-soft: 0 1px 2px rgba(0,0,0,0.3), 0 8px 30px rgba(0,0,0,0.35);
            --option-bg: #15201c;
            --option-text: #ffffff;
            color-scheme: dark;
        }
        .glass {
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow-soft);
        }

        /* Day/night toggle switch */
        .theme-switch {
            width: 44px; height: 24px; border-radius: 9999px; position: relative;
            background: var(--border-glass); border: 1px solid var(--border-glass);
            transition: background .3s ease; cursor: pointer; flex-shrink: 0;
        }
        .theme-switch .knob {
            position: absolute; top: 2px; left: 2px; width: 18px; height: 18px; border-radius: 9999px;
            background: linear-gradient(135deg, #7FA98D, #3FA796);
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            display: flex; align-items: center; justify-content: center;
        }
        html.night .theme-switch .knob { transform: translateX(20px); background: linear-gradient(135deg, #8B7FD1, #3FA796); }

        /* Theme-aware text/surface helpers — used instead of text-white/X so the
           same markup renders correctly in both day and night mode. */
        .t1 { color: var(--text-1); }
        .t2 { color: var(--text-2); }
        .t3 { color: var(--text-3); }
        .surf-1 { background: var(--bg-glass); }
        .surf-2 { background: var(--bg-glass-hover); }
        .hover-surf:hover { background: var(--bg-glass-hover); }
        .hairline { border-color: var(--border-glass) !important; }
    </style>
</head>
<body
    x-data="{ night: document.documentElement.classList.contains('night') }"
    x-init="$watch('night', v => { document.documentElement.classList.toggle('night', v); localStorage.setItem('calmacad-theme', v ? 'night' : 'day'); })"
    class="font-sans antialiased transition-colors duration-300"
    style="background: var(--bg-page); color: var(--text-1);"
>

    {{-- Status rail — slides in from the right edge, doesn't block content like a modal banner --}}
    @if (session('success') || session('error') || session('info'))
        @php
            $kind = session('success') ? 'success' : (session('error') ? 'error' : 'info');
            $bar = ['success' => '#7FA98D', 'error' => '#E8775A', 'info' => '#3FA796'][$kind];
        @endphp
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-end="opacity-0"
            class="fixed top-5 right-5 z-50 max-w-sm rounded-2xl glass overflow-hidden flex"
        >
            <span class="w-1.5 shrink-0" style="background: {{ $bar }};"></span>
            <p class="px-4 py-3.5 text-sm font-medium" style="color: var(--text-1);">
                {{ session('success') ?? session('error') ?? session('info') }}
            </p>
        </div>
    @endif

    {{ $slot }}

</body>
</html>