<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CalmAcad') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg: #F4F2EC; --bg-card: rgba(255,255,255,0.78); --bg-card-h: rgba(255,255,255,0.96);
            --border: rgba(31,46,43,0.09); --border-em: rgba(31,46,43,0.18);
            --t1: #1C2321; --t2: rgba(28,35,33,0.60); --t3: rgba(28,35,33,0.38);
            --dot: rgba(31,46,43,0.055); --blob-op: 0.06;
            --shadow: 0 1px 3px rgba(28,35,33,0.05), 0 8px 28px rgba(28,35,33,0.07);
            --green: #7FA98D; --teal: #3FA796;
            --accent-bg: rgba(127,169,141,0.10); --accent-bg-h: rgba(127,169,141,0.17);
            --danger: #C1554B; --danger-bg: rgba(193,85,75,0.08);
            color-scheme: light;
        }
        html.night {
            --bg: #080c0b; --bg-card: rgba(255,255,255,0.038); --bg-card-h: rgba(255,255,255,0.065);
            --border: rgba(255,255,255,0.085); --border-em: rgba(255,255,255,0.15);
            --t1: #f0eeea; --t2: rgba(240,238,234,0.55); --t3: rgba(240,238,234,0.33);
            --dot: rgba(255,255,255,0.03); --blob-op: 1;
            --shadow: 0 1px 3px rgba(0,0,0,0.28), 0 10px 32px rgba(0,0,0,0.38);
            --accent-bg: rgba(127,169,141,0.12); --accent-bg-h: rgba(127,169,141,0.22);
            --danger-bg: rgba(193,85,75,0.12);
            color-scheme: dark;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        html{font-size:16px;}
        body{
            font-family:'Inter',sans-serif; background:var(--bg); color:var(--t1);
            min-height:100dvh; display:flex; flex-direction:column; align-items:center; justify-content:center;
            -webkit-font-smoothing:antialiased; transition:background .3s,color .3s; padding:1.5rem;
        }
        .display{font-family:'Fraunces',Georgia,serif;}
        .mono{font-family:'IBM Plex Mono',monospace;}
        .t2{color:var(--t2);}
        .t3{color:var(--t3);}

        .glass{
            background:var(--bg-card); backdrop-filter:blur(18px); -webkit-backdrop-filter:blur(18px);
            border:1px solid var(--border); box-shadow:var(--shadow);
        }

        .bg-layer{pointer-events:none; position:fixed; inset:0; z-index:0;}
        .bg-blobs{opacity:var(--blob-op); transition:opacity .4s;}
        @keyframes drift1{0%,100%{transform:translate(0,0)}50%{transform:translate(44px,56px)}}
        @keyframes drift2{0%,100%{transform:translate(0,0)}50%{transform:translate(-52px,38px)}}
        .blob{position:absolute; border-radius:50%; filter:blur(110px);}
        .blob-1{width:560px;height:560px;top:-100px;left:-80px;background:radial-gradient(circle,#7FA98D,transparent 70%);opacity:.20;animation:drift1 24s ease-in-out infinite;}
        .blob-2{width:480px;height:480px;top:30%;right:-100px;background:radial-gradient(circle,#8B7FD1,transparent 70%);opacity:.16;animation:drift2 28s ease-in-out infinite;}
        .bg-dots{background-image:radial-gradient(circle, var(--dot) 1px, transparent 1px); background-size:26px 26px; opacity:.7;}

        @media (prefers-reduced-motion: reduce){ .blob{animation:none !important;} }

        /* ─── Toggle ─── */
        .toggle-fixed{position:fixed; top:1.25rem; right:1.25rem; z-index:30; display:flex; align-items:center; gap:.5rem;}
        .toggle-fixed svg{width:14px;height:14px;color:var(--t3);}
        .toggle{
            width:42px;height:23px;border-radius:9999px; background:var(--border); border:1px solid var(--border-em);
            position:relative; cursor:pointer; transition:background .3s;
        }
        .toggle .knob{
            position:absolute; top:2px; left:2px; width:17px; height:17px; border-radius:9999px;
            background:linear-gradient(135deg, var(--green), var(--teal)); transition:transform .3s cubic-bezier(.4,0,.2,1);
        }
        html.night .toggle .knob{transform:translateX(19px);}

        /* ─── Auth card ─── */
        .auth-wrap{ position:relative; z-index:10; width:100%; max-width:400px; }
        .auth-logo{ display:flex; align-items:center; justify-content:center; gap:.625rem; margin-bottom:1.75rem; text-decoration:none; }
        .auth-logo-icon{
            width:34px;height:34px;border-radius:50%; flex-shrink:0;
            display:flex;align-items:center;justify-content:center;
            background:linear-gradient(135deg, var(--green), var(--teal));
        }
        .auth-logo-icon svg{width:17px;height:17px;}
        .auth-logo-text{font-family:'Fraunces',serif; font-size:1.3rem; font-weight:600; color:var(--t1);}

        .auth-card{ border-radius:1.25rem; padding:2.25rem 2rem; }

        .auth-title{ font-family:'Fraunces',serif; font-size:1.5rem; font-weight:600; color:var(--t1); margin-bottom:.375rem; text-align:center;}
        .auth-sub{ font-size:.84rem; color:var(--t2); text-align:center; margin-bottom:1.75rem; line-height:1.6; }

        /* ─── Form ─── */
        .field{ margin-bottom:1.1rem; }
        .field label{
            display:block; font-size:.78rem; font-weight:500; color:var(--t2);
            margin-bottom:.4rem; letter-spacing:.01em;
        }
        .field input{
            width:100%; padding:.7rem .9rem; border-radius:.65rem;
            border:1px solid var(--border-em); background:var(--bg-card);
            color:var(--t1); font-size:.875rem; font-family:'Inter',sans-serif;
            transition:border-color .2s, background .2s;
        }
        .field input:focus{
            outline:none; border-color:var(--green);
            background:var(--bg-card-h);
        }
        .field input::placeholder{ color:var(--t3); }
        .field-error{ font-size:.74rem; color:var(--danger); margin-top:.4rem; }

        .check-row{ display:flex; align-items:center; gap:.5rem; margin-bottom:1.5rem; }
        .check-row input[type=checkbox]{
            width:16px; height:16px; border-radius:.3rem; accent-color: var(--green); cursor:pointer;
        }
        .check-row span{ font-size:.82rem; color:var(--t2); }

        .auth-actions{ display:flex; align-items:center; justify-content:space-between; gap:.75rem; margin-top:.25rem; }
        .auth-actions.end{ justify-content:flex-end; }

        .btn{
            display:inline-flex; align-items:center; justify-content:center;
            border-radius:9999px; font-size:.875rem; font-weight:500;
            padding:.7rem 1.6rem; text-decoration:none; transition:opacity .18s, transform .18s;
            white-space:nowrap; cursor:pointer; border:none;
        }
        .btn:hover{ opacity:.88; transform:translateY(-1px); }
        .btn:active{ transform:scale(.98); }
        .btn-primary{
            color:#fff; background:linear-gradient(135deg, var(--green), var(--teal));
            box-shadow:0 4px 18px rgba(127,169,141,.32); width:100%;
        }
        .btn-block{ width:100%; }

        .auth-link{
            font-size:.8rem; color:var(--t2); text-decoration:underline; text-underline-offset:2px;
            transition:color .15s;
        }
        .auth-link:hover{ color:var(--t1); }

        .auth-status{
            border-radius:.75rem; padding:.85rem 1rem; margin-bottom:1.25rem;
            background: rgba(63,167,150,0.1); border:1px solid rgba(63,167,150,0.25);
            font-size:.82rem; color: var(--t1);
        }

        .auth-footer{ text-align:center; margin-top:1.5rem; font-size:.82rem; color:var(--t2); }
        .auth-footer a{ color: var(--green); font-weight:500; text-decoration:none; }
        .auth-footer a:hover{ text-decoration:underline; }

        [x-cloak]{ display:none !important; }
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
    <div class="bg-layer bg-blobs" aria-hidden="true">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>
    <div class="bg-layer bg-dots" aria-hidden="true"></div>

    <div class="toggle-fixed" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
        <button type="button" class="toggle" role="switch" :aria-checked="night" @click="night = !night" aria-label="Ganti mode siang atau malam">
            <span class="knob"></span>
        </button>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
    </div>

    <div class="auth-wrap">
        <a href="{{ url('/') }}" class="auth-logo" aria-label="CalmAcad — beranda">
            <span class="auth-logo-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="#0a1110" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h4l2 7 4-14 2 7h6"/></svg>
            </span>
            <span class="auth-logo-text">CalmAcad</span>
        </a>

        <div class="glass auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>