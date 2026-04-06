<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DormiHub') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font: 'Sora', system-ui, sans-serif;
            --mono: 'JetBrains Mono', monospace;
            --nav-h: 60px;

            --bg:        #F5F4F0;
            --surface:   #FFFFFF;
            --surface-2: #EFEDE8;
            --border:    rgba(0,0,0,0.07);
            --border-md: rgba(0,0,0,0.12);
            --text:      #16150F;
            --text-2:    #5C5A54;
            --text-3:    #9B9890;

            --ink:       #16150F;
            --accent:    #1A56DB;
            --accent-bg: #EEF3FF;
            --accent-tx: #1A4BB5;
            --green:     #0E9F6E;
            --green-bg:  #ECFDF5;
            --red:       #E02424;
            --red-bg:    #FEF2F2;
            --amber:     #C27803;
            --amber-bg:  #FFFBEB;

            --shadow-sm: 0 1px 2px rgba(0,0,0,.05);
            --shadow:    0 2px 8px rgba(0,0,0,.08), 0 1px 3px rgba(0,0,0,.05);
            --r:  8px;
            --r2: 12px;
            --r3: 16px;
        }

        .dark {
            --bg:        #111009;
            --surface:   #1C1B14;
            --surface-2: #23221A;
            --border:    rgba(255,255,255,0.07);
            --border-md: rgba(255,255,255,0.12);
            --text:      #F0EEE8;
            --text-2:    #9A9890;
            --text-3:    #615F58;
            --ink:       #F0EEE8;
            --accent:    #3F6FEF;
            --accent-bg: rgba(63,111,239,.12);
            --accent-tx: #7BA3F8;
            --green:     #31C48D;
            --green-bg:  rgba(14,159,110,.12);
            --red:       #F05252;
            --red-bg:    rgba(224,36,36,.12);
            --amber:     #F59E0B;
            --amber-bg:  rgba(194,120,3,.12);
            --shadow-sm: 0 1px 2px rgba(0,0,0,.3);
            --shadow:    0 2px 8px rgba(0,0,0,.4);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }
        [x-cloak] { display: none !important; }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── NAV ─────────────────────────────────── */
        .nav {
            position: sticky; top: 0; z-index: 50;
            height: var(--nav-h);
            background: rgba(245,244,240,.88);
            backdrop-filter: blur(16px) saturate(1.4);
            -webkit-backdrop-filter: blur(16px) saturate(1.4);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
        }
        .dark .nav { background: rgba(17,16,9,.88); }
        .nav-inner {
            max-width: 1280px; width: 100%; margin: 0 auto;
            padding: 0 24px;
            display: flex; align-items: center; gap: 0;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 9px;
            text-decoration: none; margin-right: 36px;
        }
        .nav-logo {
            width: 30px; height: 30px; border-radius: 7px;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
            font-family: var(--mono);
        }
        .nav-wordmark {
            font-size: 15px; font-weight: 600; color: var(--text);
            letter-spacing: -.3px;
        }
        .nav-wordmark span { color: var(--accent); }

        .nav-links { display: flex; align-items: center; gap: 2px; flex: 1; }
        .nav-link {
            padding: 6px 12px; border-radius: var(--r);
            font-size: 13.5px; font-weight: 400; color: var(--text-2);
            text-decoration: none;
            transition: background .15s, color .15s;
            white-space: nowrap;
        }
        .nav-link:hover { background: var(--surface-2); color: var(--text); }
        .nav-link.active {
            background: var(--surface-2); color: var(--text);
            font-weight: 500;
        }

        .nav-right { display: flex; align-items: center; gap: 10px; margin-left: auto; }

        /* User dropdown */
        .user-menu { position: relative; }
        .user-trigger {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 10px 5px 5px;
            border: 1px solid var(--border-md);
            border-radius: 99px;
            background: var(--surface);
            cursor: pointer;
            font-size: 13px; color: var(--text-2);
            transition: background .15s, border-color .15s;
        }
        .user-trigger:hover { background: var(--surface-2); border-color: var(--border-md); }
        .user-avatar {
            width: 26px; height: 26px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #7C3AED);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600; color: #fff;
            flex-shrink: 0;
        }
        .user-name { font-weight: 500; color: var(--text); }
        .user-caret { width: 14px; height: 14px; color: var(--text-3); transition: transform .2s; }
        .user-trigger[aria-expanded="true"] .user-caret { transform: rotate(180deg); }

        .dropdown {
            position: absolute; top: calc(100% + 8px); right: 0;
            min-width: 200px;
            background: var(--surface);
            border: 1px solid var(--border-md);
            border-radius: var(--r2);
            box-shadow: var(--shadow);
            overflow: hidden;
            z-index: 100;
        }
        .dropdown-header {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
        }
        .dropdown-name { font-size: 13px; font-weight: 600; color: var(--text); }
        .dropdown-role { font-size: 11px; color: var(--text-3); text-transform: capitalize; margin-top: 1px; }
        .dropdown-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 14px; font-size: 13px; color: var(--text-2);
            text-decoration: none; cursor: pointer;
            transition: background .12s, color .12s;
            width: 100%; border: none; background: none; text-align: left;
        }
        .dropdown-item:hover { background: var(--surface-2); color: var(--text); }
        .dropdown-item.danger:hover { background: var(--red-bg); color: var(--red); }
        .dropdown-item svg { width: 14px; height: 14px; flex-shrink: 0; }
        .dropdown-sep { height: 1px; background: var(--border); margin: 4px 0; }

        /* Dark mode toggle */
        .theme-btn {
            width: 32px; height: 32px; border-radius: var(--r);
            border: 1px solid var(--border-md);
            background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text-2);
            transition: background .15s, color .15s;
        }
        .theme-btn:hover { background: var(--surface-2); color: var(--text); }
        .theme-btn svg { width: 15px; height: 15px; }

        /* Auth CTA */
        .btn-nav-login {
            padding: 6px 14px; border-radius: var(--r);
            font-size: 13px; font-weight: 500;
            border: 1px solid var(--border-md);
            background: var(--surface); color: var(--text-2);
            text-decoration: none;
            transition: background .15s;
        }
        .btn-nav-login:hover { background: var(--surface-2); color: var(--text); }
        .btn-nav-reg {
            padding: 6px 14px; border-radius: var(--r);
            font-size: 13px; font-weight: 500;
            background: var(--accent); color: #fff;
            text-decoration: none;
            transition: opacity .15s;
        }
        .btn-nav-reg:hover { opacity: .88; }

        /* Mobile hamburger */
        .hamburger {
            display: none; padding: 6px; margin-left: auto;
            background: none; border: none; cursor: pointer;
            color: var(--text-2); border-radius: var(--r);
        }
        .hamburger:hover { background: var(--surface-2); }
        .hamburger svg { width: 20px; height: 20px; }

        /* Mobile menu */
        .mobile-nav {
            position: fixed; top: var(--nav-h); left: 0; right: 0;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 12px 16px 16px;
            z-index: 49;
            display: flex; flex-direction: column; gap: 4px;
            box-shadow: var(--shadow);
        }
        .mobile-link {
            padding: 9px 12px; border-radius: var(--r);
            font-size: 14px; color: var(--text-2);
            text-decoration: none;
            transition: background .12s, color .12s;
        }
        .mobile-link:hover, .mobile-link.active { background: var(--surface-2); color: var(--text); }

        @media (max-width: 768px) {
            .nav-links, .nav-right .btn-nav-login, .nav-right .btn-nav-reg,
            .user-menu { display: none; }
            .hamburger { display: flex; }
        }

        /* ─── PAGE HEADER ─────────────────────────── */
        .page-header-bar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }
        .page-header-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 16px 24px;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 8px;
        }
        .page-header-title {
            font-size: 17px; font-weight: 600;
            color: var(--text); letter-spacing: -.35px; margin: 0;
        }

        /* ─── MAIN WRAPPER ───────────────────────── */
        .main-wrapper {
            max-width: 1280px; margin: 0 auto;
            padding: 28px 24px;
        }

        /* ─── SCROLLBAR ───────────────────────────── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-md); border-radius: 99px; }
    </style>
</head>
<body
    x-data="{
        mobileOpen: false,
        userOpen: false,
        darkMode: localStorage.getItem('darkMode') === 'true'
    }"
    x-init="
        if(darkMode) document.documentElement.classList.add('dark');
        $watch('darkMode', val => {
            localStorage.setItem('darkMode', val);
            val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
        });
    "
    :class="{ 'dark': darkMode }"
>

<!-- ── Navigation ── -->
<nav class="nav">
    <div class="nav-inner">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <div class="nav-logo">D</div>
            <span class="nav-wordmark">Dormi<span>Hub</span></span>
        </a>

        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('rooms.index') }}" class="nav-link {{ request()->routeIs('rooms.*') && !request()->routeIs('rooms.create') ? 'active' : '' }}">Rooms</a>
            @auth @if(auth()->user()->isAdmin())
            <a href="{{ route('rooms.create') }}" class="nav-link {{ request()->routeIs('rooms.create') ? 'active' : '' }}">Add Room</a>
            @endif @endauth
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
        </div>

        <div class="nav-right">
            <button @click="darkMode = !darkMode" class="theme-btn" :title="darkMode ? 'Light mode' : 'Dark mode'">
                <svg x-show="!darkMode" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg x-show="darkMode" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </button>

            @auth
            <div class="user-menu" x-data @click.away="userOpen = false">
                <button class="user-trigger" @click="userOpen = !userOpen" :aria-expanded="userOpen">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <span class="user-name">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    <svg class="user-caret" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="dropdown" x-show="userOpen" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="dropdown-header">
                        <div class="dropdown-name">{{ auth()->user()->name }}</div>
                        <div class="dropdown-role">{{ auth()->user()->role }} · {{ auth()->user()->email }}</div>
                    </div>
                    <div class="dropdown-sep"></div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profile settings
                    </a>
                    <div class="dropdown-sep"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" class="btn-nav-login">Sign in</a>
            <a href="{{ route('register') }}" class="btn-nav-reg">Get started</a>
            @endauth
        </div>

        <!-- Mobile hamburger -->
        <button class="hamburger" @click="mobileOpen = !mobileOpen">
            <svg x-show="!mobileOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="mobileOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</nav>

<!-- Mobile menu -->
<div class="mobile-nav" x-show="mobileOpen" x-cloak @click.away="mobileOpen = false">
    <a href="{{ route('dashboard') }}" class="mobile-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('rooms.index') }}" class="mobile-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">Rooms</a>
    @auth @if(auth()->user()->isAdmin())
    <a href="{{ route('rooms.create') }}" class="mobile-link">Add Room</a>
    @endif @endauth
    <a href="{{ route('about') }}" class="mobile-link">About</a>
    <div style="height:1px;background:var(--border);margin:8px 0;"></div>
    @auth
    <a href="{{ route('profile.edit') }}" class="mobile-link">Profile</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="mobile-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;color:var(--red);font-family:var(--font);font-size:14px;">Sign out</button>
    </form>
    @else
    <a href="{{ route('login') }}" class="mobile-link">Sign in</a>
    <a href="{{ route('register') }}" class="mobile-link" style="background:var(--accent);color:#fff;">Get started</a>
    @endauth
</div>

<!-- ── Page Header (Breeze slot) ── -->
@isset($header)
<div class="page-header-bar">
    <div class="page-header-inner">
        {{ $header }}
    </div>
</div>
@endisset

<!-- ── Page Content ── -->
<main>
    <div class="main-wrapper">
        {{ $slot }}
    </div>
</main>

</body>
</html>