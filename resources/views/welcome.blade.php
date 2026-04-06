<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DormiHub — Smart Dormitory Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font: 'Sora', system-ui, sans-serif;
            --mono: 'JetBrains Mono', monospace;
            --ink: #0F0E09;
            --ink-2: #4A4840;
            --ink-3: #8E8C84;
            --surface: #FFFFFF;
            --surface-2: #F5F3EE;
            --border: rgba(0,0,0,.07);
            --border-md: rgba(0,0,0,.11);
            --accent: #1A56DB;
            --accent-2: #1341B0;
            --green: #0E9F6E;
            --green-bg: #ECFDF5;
            --red: #E02424;
            --red-bg: #FEF2F2;
            --amber: #C27803;
            --amber-bg: #FFFBEB;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font);
            background: var(--surface);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ── NAV ─────────────────────────────────── */
        .lp-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            height: 60px;
            display: flex; align-items: center;
            transition: background .3s, box-shadow .3s, border-color .3s;
        }
        .lp-nav.scrolled {
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 4px rgba(0,0,0,.05);
        }
        .lp-nav-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 28px;
            display: flex; align-items: center; width: 100%; gap: 32px;
        }
        .lp-brand {
            display: flex; align-items: center; gap: 9px; text-decoration: none;
        }
        .lp-logo {
            width: 32px; height: 32px; border-radius: 8px;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff;
            font-family: var(--mono);
        }
        .lp-wordmark { font-size: 16px; font-weight: 700; color: var(--ink); letter-spacing: -.4px; }
        .lp-wordmark span { color: var(--accent); }
        .lp-links { display: flex; gap: 4px; flex: 1; }
        .lp-link {
            padding: 6px 12px; border-radius: 8px;
            font-size: 14px; color: var(--ink-2); text-decoration: none;
            transition: background .15s, color .15s;
        }
        .lp-link:hover { background: var(--surface-2); color: var(--ink); }
        .lp-nav-cta { display: flex; gap: 8px; margin-left: auto; align-items: center; }
        .lp-btn-ghost {
            padding: 7px 16px; border-radius: 8px;
            font-size: 14px; font-weight: 500; color: var(--ink-2);
            border: 1px solid var(--border-md); background: transparent;
            text-decoration: none; transition: background .15s, color .15s;
        }
        .lp-btn-ghost:hover { background: var(--surface-2); color: var(--ink); }
        .lp-btn-cta {
            padding: 7px 18px; border-radius: 8px;
            font-size: 14px; font-weight: 600; color: #fff;
            background: var(--accent); text-decoration: none;
            transition: background .15s, box-shadow .15s;
            box-shadow: 0 1px 4px rgba(26,86,219,.3);
        }
        .lp-btn-cta:hover { background: var(--accent-2); box-shadow: 0 3px 10px rgba(26,86,219,.35); }

        /* ── HERO ─────────────────────────────────── */
        .hero {
            min-height: 100vh;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center;
            padding: 100px 28px 60px;
            background: #0B0A05;
            position: relative; overflow: hidden;
        }

        /* Grid background */
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
        }

        /* Glow orbs */
        .hero-orb {
            position: absolute; border-radius: 50%;
            filter: blur(100px); pointer-events: none;
        }
        .hero-orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(26,86,219,.35) 0%, transparent 70%);
            top: -100px; left: -100px;
            animation: float1 12s ease-in-out infinite;
        }
        .hero-orb-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(124,58,237,.25) 0%, transparent 70%);
            bottom: -80px; right: -80px;
            animation: float2 14s ease-in-out infinite;
        }
        .hero-orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(14,159,110,.2) 0%, transparent 70%);
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            animation: float1 10s ease-in-out infinite reverse;
        }

        @keyframes float1 { 0%,100% { transform: translate(0,0); } 50% { transform: translate(30px, 20px); } }
        @keyframes float2 { 0%,100% { transform: translate(0,0); } 50% { transform: translate(-25px, -15px); } }

        .hero-content { position: relative; z-index: 2; max-width: 760px; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 5px 14px; border-radius: 99px;
            background: rgba(26,86,219,.15);
            border: 1px solid rgba(26,86,219,.3);
            font-size: 12px; font-weight: 500; color: #7BA3F8;
            letter-spacing: .04em; text-transform: uppercase;
            margin-bottom: 28px;
            animation: fadeUp .6s ease both;
        }
        .hero-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #7BA3F8; animation: pulse 2s ease-in-out infinite; }
        @keyframes pulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:.5; transform:scale(.8); } }

        .hero-title {
            font-size: clamp(38px, 6vw, 72px);
            font-weight: 800; line-height: 1.06;
            letter-spacing: -.03em;
            color: #F0EEE8;
            margin: 0 0 24px;
            animation: fadeUp .6s .1s ease both;
        }
        .hero-title-accent {
            background: linear-gradient(135deg, #60A5FA 0%, #818CF8 50%, #A78BFA 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: clamp(16px, 2vw, 19px);
            color: #6B6960; line-height: 1.7;
            max-width: 540px; margin: 0 auto 40px;
            font-weight: 300;
            animation: fadeUp .6s .2s ease both;
        }

        .hero-actions {
            display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;
            animation: fadeUp .6s .3s ease both;
        }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px; border-radius: 10px;
            font-size: 15px; font-weight: 600; color: #fff;
            background: var(--accent);
            text-decoration: none;
            transition: background .15s, box-shadow .15s, transform .15s;
            box-shadow: 0 4px 20px rgba(26,86,219,.4);
        }
        .btn-hero-primary:hover { background: var(--accent-2); transform: translateY(-1px); box-shadow: 0 6px 24px rgba(26,86,219,.5); }
        .btn-hero-primary svg { width: 16px; height: 16px; }
        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 24px; border-radius: 10px;
            font-size: 15px; font-weight: 500; color: #B0ADA5;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            text-decoration: none;
            transition: background .15s, color .15s;
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,.11); color: #F0EEE8; }

        @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }

        /* Floating stats bar */
        .hero-stats {
            display: flex; gap: 0; margin-top: 60px;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 14px; overflow: hidden;
            animation: fadeUp .6s .45s ease both;
            backdrop-filter: blur(12px);
        }
        .hero-stat {
            flex: 1; padding: 20px 28px; text-align: center;
            border-right: 1px solid rgba(255,255,255,.08);
        }
        .hero-stat:last-child { border-right: none; }
        .hero-stat-num {
            font-size: 26px; font-weight: 700; color: #F0EEE8;
            letter-spacing: -.04em; font-family: var(--mono);
            display: block;
        }
        .hero-stat-label { font-size: 12px; color: #6B6960; margin-top: 2px; }

        /* ── FEATURES ─────────────────────────────── */
        .section {
            padding: 96px 28px;
            max-width: 1200px; margin: 0 auto;
        }
        .section-label {
            font-size: 11px; font-weight: 600; letter-spacing: .1em;
            text-transform: uppercase; color: var(--accent);
            display: block; margin-bottom: 12px;
        }
        .section-title {
            font-size: clamp(28px, 4vw, 44px); font-weight: 700;
            letter-spacing: -.03em; color: var(--ink);
            margin: 0 0 16px; line-height: 1.15;
        }
        .section-sub {
            font-size: 17px; color: var(--ink-2); max-width: 520px;
            line-height: 1.7; font-weight: 300; margin: 0;
        }
        .section-header { margin-bottom: 56px; }

        /* Feature bento grid */
        .bento {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: auto;
            gap: 16px;
        }
        .bento-card {
            background: var(--surface);
            border: 1px solid var(--border-md);
            border-radius: 16px; padding: 28px;
            position: relative; overflow: hidden;
            transition: box-shadow .2s, border-color .2s, transform .2s;
        }
        .bento-card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,.08);
            border-color: rgba(0,0,0,.15);
            transform: translateY(-2px);
        }
        .bento-1 { grid-column: span 5; }
        .bento-2 { grid-column: span 7; }
        .bento-3 { grid-column: span 4; }
        .bento-4 { grid-column: span 4; }
        .bento-5 { grid-column: span 4; }

        @media (max-width: 900px) {
            .bento-1, .bento-2, .bento-3, .bento-4, .bento-5 { grid-column: span 12; }
        }

        .feature-icon {
            width: 44px; height: 44px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px; flex-shrink: 0;
        }
        .feature-icon svg { width: 20px; height: 20px; }
        .fi-blue { background: #EEF3FF; color: var(--accent); }
        .fi-green { background: #ECFDF5; color: var(--green); }
        .fi-purple { background: #F5F3FF; color: #7C3AED; }
        .fi-amber { background: #FFFBEB; color: var(--amber); }
        .fi-red { background: #FEF2F2; color: var(--red); }

        .feature-title { font-size: 17px; font-weight: 600; color: var(--ink); margin: 0 0 8px; letter-spacing: -.3px; }
        .feature-desc { font-size: 14px; color: var(--ink-2); line-height: 1.65; margin: 0; font-weight: 300; }

        /* Status preview in bento card */
        .status-preview {
            margin-top: 24px; display: flex; flex-direction: column; gap: 8px;
        }
        .sp-row {
            display: flex; align-items: center; justify-content: space-between;
            background: var(--surface-2); border-radius: 8px; padding: 10px 14px;
            font-size: 13px;
        }
        .sp-room { font-weight: 500; color: var(--ink); font-family: var(--mono); font-size: 12px; }
        .sp-type { color: var(--ink-3); font-size: 12px; }
        .sp-badge {
            padding: 3px 9px; border-radius: 99px;
            font-size: 11px; font-weight: 500;
        }
        .sp-badge.av { background: var(--green-bg); color: var(--green); }
        .sp-badge.oc { background: var(--red-bg); color: var(--red); }
        .sp-badge.mt { background: var(--amber-bg); color: var(--amber); }

        /* Role badges in bento */
        .role-grid { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 20px; }
        .role-pill {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 14px; border-radius: 99px;
            border: 1px solid var(--border-md); font-size: 13px; font-weight: 500;
        }
        .role-pill .dot { width: 7px; height: 7px; border-radius: 50%; }
        .rp-admin .dot { background: var(--accent); }
        .rp-admin { color: var(--accent); background: var(--surface-2); border-color: rgba(26,86,219,.2); }
        .rp-user .dot { background: var(--green); }
        .rp-user { color: var(--green); background: var(--green-bg); border-color: rgba(14,159,110,.2); }

        /* ── STATS SECTION ────────────────────────── */
        .stats-section {
            background: #0B0A05;
            padding: 80px 28px;
        }
        .stats-inner { max-width: 1200px; margin: 0 auto; }
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 1px; background: rgba(255,255,255,.06);
            border-radius: 16px; overflow: hidden;
            border: 1px solid rgba(255,255,255,.06);
        }
        @media (max-width: 700px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        .stat-box {
            padding: 36px 32px; background: #0F0E09;
            text-align: center;
        }
        .stat-box-num {
            font-size: 48px; font-weight: 700;
            letter-spacing: -.04em; color: #F0EEE8;
            font-family: var(--mono);
            display: block; line-height: 1;
        }
        .stat-box-label { font-size: 13px; color: #5B5950; margin-top: 8px; }

        /* ── HOW IT WORKS ─────────────────────────── */
        .steps-section { padding: 96px 28px; background: var(--surface-2); }
        .steps-inner { max-width: 1200px; margin: 0 auto; }
        .steps-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px;
            margin-top: 56px;
        }
        @media (max-width: 768px) { .steps-grid { grid-template-columns: 1fr; } }
        .step {
            position: relative; padding: 32px;
            background: var(--surface); border-radius: 16px;
            border: 1px solid var(--border-md);
        }
        .step-number {
            font-size: 11px; font-weight: 600; color: var(--accent);
            letter-spacing: .08em; font-family: var(--mono);
            margin-bottom: 16px; display: block;
        }
        .step-title { font-size: 18px; font-weight: 600; color: var(--ink); margin: 0 0 10px; letter-spacing: -.3px; }
        .step-desc { font-size: 14px; color: var(--ink-2); line-height: 1.65; margin: 0; font-weight: 300; }
        .step-connector {
            position: absolute; top: 44px; right: -16px;
            width: 32px; height: 2px; background: var(--border-md);
            display: none;
        }
        @media (min-width: 768px) { .step:not(:last-child) .step-connector { display: block; } }

        /* ── CTA SECTION ──────────────────────────── */
        .cta-section {
            padding: 96px 28px;
            background: linear-gradient(135deg, #0B0A05 0%, #111540 50%, #0B0A05 100%);
            text-align: center; position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }
        .cta-inner { max-width: 600px; margin: 0 auto; position: relative; z-index: 1; }
        .cta-title { font-size: clamp(28px, 4vw, 44px); font-weight: 700; color: #F0EEE8; letter-spacing: -.03em; margin: 0 0 16px; }
        .cta-sub { font-size: 17px; color: #6B6960; margin: 0 0 40px; font-weight: 300; line-height: 1.7; }
        .cta-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        /* ── FOOTER ───────────────────────────────── */
        .lp-footer {
            background: #0B0A05;
            border-top: 1px solid rgba(255,255,255,.06);
            padding: 36px 28px;
        }
        .footer-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 16px;
        }
        .footer-copy { font-size: 13px; color: #3B3A34; }
        .footer-links { display: flex; gap: 20px; }
        .footer-link { font-size: 13px; color: #3B3A34; text-decoration: none; transition: color .15s; }
        .footer-link:hover { color: #6B6960; }
    </style>
</head>
<body>

<!-- ── Navigation ── -->
<nav class="lp-nav" id="lp-nav">
    <div class="lp-nav-inner">
        <a href="/" class="lp-brand">
            <div class="lp-logo">D</div>
            <span class="lp-wordmark">Dormi<span>Hub</span></span>
        </a>
        <div class="lp-links">
            <a href="#features" class="lp-link">Features</a>
            <a href="#how-it-works" class="lp-link">How it works</a>
            <a href="{{ route('about') }}" class="lp-link">About</a>
        </div>
        <div class="lp-nav-cta">
            @auth
            <a href="{{ route('dashboard') }}" class="lp-btn-ghost">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="lp-btn-ghost">Sign in</a>
            <a href="{{ route('register') }}" class="lp-btn-cta">Get started free</a>
            @endauth
        </div>
    </div>
</nav>

<!-- ── Hero ── -->
<section class="hero">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>

    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            Smart Dormitory Management
        </div>

        <h1 class="hero-title">
            Manage your dorm<br>
            <span class="hero-title-accent">rooms with clarity</span>
        </h1>

        <p class="hero-sub">
            DormiHub gives dormitory operators and residents a single place to track rooms, occupancy, and pricing — beautifully simple.
        </p>

        <div class="hero-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                Get started — it's free
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                Sign in to dashboard
            </a>
        </div>

        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-num">3</span>
                <div class="hero-stat-label">Room types</div>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">2</span>
                <div class="hero-stat-label">User roles</div>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">100%</span>
                <div class="hero-stat-label">Web-based</div>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">∞</span>
                <div class="hero-stat-label">Rooms supported</div>
            </div>
        </div>
    </div>
</section>

<!-- ── Features ── -->
<section id="features">
    <div class="section">
        <div class="section-header">
            <span class="section-label">Features</span>
            <h2 class="section-title">Everything you need,<br>nothing you don't</h2>
            <p class="section-sub">A focused set of tools designed specifically for dormitory management — no bloat, no confusion.</p>
        </div>

        <div class="bento">
            <!-- Card 1: Room overview -->
            <div class="bento-card bento-1">
                <div class="feature-icon fi-blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                </div>
                <h3 class="feature-title">Live room status</h3>
                <p class="feature-desc">See every room's status at a glance — available, occupied, or under maintenance.</p>
                <div class="status-preview">
                    <div class="sp-row">
                        <div><div class="sp-room">101</div><div class="sp-type">Single</div></div>
                        <span class="sp-badge av">Available</span>
                    </div>
                    <div class="sp-row">
                        <div><div class="sp-room">204</div><div class="sp-type">Double</div></div>
                        <span class="sp-badge oc">Occupied</span>
                    </div>
                    <div class="sp-row">
                        <div><div class="sp-room">312</div><div class="sp-type">Dormitory</div></div>
                        <span class="sp-badge mt">Maintenance</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Dashboard analytics -->
            <div class="bento-card bento-2" style="background: #0B0A05; border-color: rgba(255,255,255,.08);">
                <div class="feature-icon" style="background:rgba(26,86,219,.15);color:#60A5FA;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="feature-title" style="color:#F0EEE8;">Dashboard analytics</h3>
                <p class="feature-desc" style="color:#5B5950;">Track total rooms, occupancy rate, and availability metrics from a single, clean dashboard.</p>
                <!-- Mini bar chart visualization -->
                <div style="display:flex;align-items:flex-end;gap:8px;height:80px;margin-top:24px;padding:16px;background:rgba(255,255,255,.04);border-radius:10px;border:1px solid rgba(255,255,255,.06);">
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                        <div style="width:100%;background:#1A56DB;border-radius:4px 4px 0 0;height:60px;"></div>
                        <span style="font-size:10px;color:#3B3A34;">Total</span>
                    </div>
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                        <div style="width:100%;background:#0E9F6E;border-radius:4px 4px 0 0;height:38px;"></div>
                        <span style="font-size:10px;color:#3B3A34;">Avail</span>
                    </div>
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                        <div style="width:100%;background:#E02424;border-radius:4px 4px 0 0;height:18px;"></div>
                        <span style="font-size:10px;color:#3B3A34;">Occup</span>
                    </div>
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                        <div style="width:100%;background:#C27803;border-radius:4px 4px 0 0;height:8px;"></div>
                        <span style="font-size:10px;color:#3B3A34;">Maint</span>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bento-card bento-3">
                <div class="feature-icon fi-green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                </div>
                <h3 class="feature-title">Pricing control</h3>
                <p class="feature-desc">Set and update monthly rates per room type. Transparent pricing for every tenant.</p>
            </div>

            <!-- Card 4 -->
            <div class="bento-card bento-4">
                <div class="feature-icon fi-purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="feature-title">Role-based access</h3>
                <p class="feature-desc">Admins manage everything. Residents view their room details.</p>
                <div class="role-grid">
                    <span class="role-pill rp-admin"><span class="dot"></span>Admin</span>
                    <span class="role-pill rp-user"><span class="dot"></span>Resident</span>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="bento-card bento-5">
                <div class="feature-icon fi-amber">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                </div>
                <h3 class="feature-title">Flexible room types</h3>
                <p class="feature-desc">Single, double, or dormitory — manage any configuration with custom capacity settings.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── Stats ── -->
<section class="stats-section">
    <div class="stats-inner">
        <div style="text-align:center;margin-bottom:48px;">
            <span class="section-label" style="color:#60A5FA;">By the numbers</span>
            <h2 style="font-size:clamp(24px,3vw,36px);font-weight:700;color:#F0EEE8;letter-spacing:-.03em;margin:0;">Built for real dorms</h2>
        </div>
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-box-num">3</span>
                <div class="stat-box-label">Room categories</div>
            </div>
            <div class="stat-box">
                <span class="stat-box-num">3</span>
                <div class="stat-box-label">Status states</div>
            </div>
            <div class="stat-box">
                <span class="stat-box-num">2</span>
                <div class="stat-box-label">Access levels</div>
            </div>
            <div class="stat-box">
                <span class="stat-box-num">1</span>
                <div class="stat-box-label">Simple platform</div>
            </div>
        </div>
    </div>
</section>

<!-- ── How it works ── -->
<section class="steps-section" id="how-it-works">
    <div class="steps-inner">
        <div class="section-header">
            <span class="section-label">How it works</span>
            <h2 class="section-title">Up and running<br>in minutes</h2>
            <p class="section-sub">No complex setup. No training needed. Three steps to a fully managed dormitory.</p>
        </div>

        <div class="steps-grid">
            <div class="step">
                <span class="step-number">01 — REGISTER</span>
                <h3 class="step-title">Create your account</h3>
                <p class="step-desc">Sign up in seconds. Your account starts with resident access — admins can be assigned by the system administrator.</p>
                <div class="step-connector"></div>
            </div>
            <div class="step">
                <span class="step-number">02 — ADD ROOMS</span>
                <h3 class="step-title">Populate your rooms</h3>
                <p class="step-desc">Admins can add rooms with a number, type, capacity, price, and status. Each room gets its own detail page instantly.</p>
                <div class="step-connector"></div>
            </div>
            <div class="step">
                <span class="step-number">03 — MANAGE</span>
                <h3 class="step-title">Track and update</h3>
                <p class="step-desc">Update room statuses as tenants move in and out. The dashboard always shows you the current state of every room.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── CTA ── -->
<section class="cta-section">
    <div class="cta-inner">
        <h2 class="cta-title">Ready to simplify your dorm management?</h2>
        <p class="cta-sub">Join DormiHub today. Free to get started, easy to use, built for clarity.</p>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                Create your account
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                Already have an account
            </a>
        </div>
    </div>
</section>

<!-- ── Footer ── -->
<footer class="lp-footer">
    <div class="footer-inner">
        <div style="display:flex;align-items:center;gap:9px;">
            <div class="lp-logo" style="width:24px;height:24px;font-size:11px;">D</div>
            <span style="font-size:13px;color:#3B3A34;">DormiHub</span>
        </div>
        <span class="footer-copy">© {{ date('Y') }} DormiHub. All rights reserved.</span>
        <div class="footer-links">
            <a href="{{ route('about') }}" class="footer-link">About</a>
            <a href="{{ route('login') }}" class="footer-link">Sign in</a>
            <a href="{{ route('register') }}" class="footer-link">Register</a>
        </div>
    </div>
</footer>

<script>
    // Navbar scroll effect
    const nav = document.getElementById('lp-nav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });

    // Smooth reveal on scroll
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.opacity = '1';
                e.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.bento-card, .step, .stat-box').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity .5s ease, transform .5s ease';
        observer.observe(el);
    });
</script>
</body>
</html>