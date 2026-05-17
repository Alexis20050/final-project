<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DormiHub — Smart Dormitory Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font: 'Inter', system-ui, -apple-system, sans-serif;
            --mono: 'JetBrains Mono', monospace;
            --accent: #2563EB;
            --accent-2: #1D4ED8;
            --accent-light: #DBEAFE;
            --green: #059669;
            --green-bg: #ECFDF5;
            --red: #DC2626;
            --red-bg: #FEF2F2;
            --amber: #D97706;
            --amber-bg: #FFFBEB;
            --purple: #7C3AED;
            --purple-light: #F5F3FF;
        }

        /* ── LIGHT THEME ── */
        [data-theme="light"] {
            --ink: #0A0A0A;
            --ink-2: #525252;
            --ink-3: #A3A3A3;
            --surface: #FFFFFF;
            --surface-2: #FAFAFA;
            --surface-3: #F5F5F5;
            --border: rgba(0,0,0,.06);
            --border-md: rgba(0,0,0,.1);
            --hero-bg-start: #FAFAFA;
            --hero-bg-end: #FFFFFF;
            --nav-bg: rgba(255,255,255,.85);
            --card-bg: #FFFFFF;
            --section-alt: #FAFAFA;
            --cta-bg-start: #0F172A;
            --cta-bg-end: #1E293B;
            --footer-bg: #0A0A0A;
            --footer-border: rgba(255,255,255,.08);
            --footer-text: #525252;
            --footer-link: #737373;
        }

        /* ── DARK THEME ── */
        [data-theme="dark"] {
            --ink: #F0EEE8;
            --ink-2: #9A9890;
            --ink-3: #5B5950;
            --surface: #111110;
            --surface-2: #1A1917;
            --surface-3: #222120;
            --border: rgba(255,255,255,.07);
            --border-md: rgba(255,255,255,.12);
            --hero-bg-start: #0D0D0C;
            --hero-bg-end: #111110;
            --nav-bg: rgba(17,17,16,.85);
            --card-bg: #1A1917;
            --section-alt: #0D0D0C;
            --cta-bg-start: #060605;
            --cta-bg-end: #0F0E09;
            --footer-bg: #060605;
            --footer-border: rgba(255,255,255,.06);
            --footer-text: #4A4845;
            --footer-link: #5B5950;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; -webkit-font-smoothing: antialiased; }
        body {
            margin: 0;
            font-family: var(--font);
            background: var(--surface);
            color: var(--ink);
            overflow-x: hidden;
            font-feature-settings: 'ss01', 'ss02', 'cv05', 'cv09';
            transition: background .3s ease, color .3s ease;
        }

        /* ── THEME TOGGLE ── */
        .theme-toggle {
            width: 36px; height: 36px;
            border-radius: 10px;
            border: 1px solid var(--border-md);
            background: var(--surface-2);
            color: var(--ink-2);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s cubic-bezier(.4,0,.2,1);
            flex-shrink: 0;
        }
        .theme-toggle:hover {
            background: var(--surface-3);
            color: var(--ink);
            transform: translateY(-1px);
        }
        .theme-toggle svg { width: 16px; height: 16px; }
        .icon-sun { display: none; }
        .icon-moon { display: block; }
        [data-theme="dark"] .icon-sun { display: block; }
        [data-theme="dark"] .icon-moon { display: none; }

        /* ── NAVIGATION ── */
        .nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            transition: all .3s cubic-bezier(.4,0,.2,1);
        }
        .nav.scrolled {
            background: var(--nav-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
        }
        .nav-inner {
            max-width: 1280px; margin: 0 auto; padding: 0 32px;
            height: 72px; display: flex; align-items: center; gap: 48px;
        }
        .brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; transition: opacity .2s;
        }
        .brand:hover { opacity: .8; }
        .logo {
            width: 40px; height: 40px;
            position: relative;
            display: flex; align-items: center; justify-content: center;
        }
        .logo svg { width: 100%; height: 100%; filter: drop-shadow(0 2px 8px rgba(37,99,235,.2)); }
        .wordmark {
            font-size: 18px; font-weight: 700;
            color: var(--ink);
            letter-spacing: -.02em;
        }
        .wordmark span {
            background: linear-gradient(135deg, var(--accent) 0%, var(--purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links { display: flex; gap: 8px; flex: 1; }
        .nav-link {
            padding: 8px 16px; border-radius: 10px;
            font-size: 15px; font-weight: 500; color: var(--ink-2);
            text-decoration: none;
            transition: all .2s cubic-bezier(.4,0,.2,1);
        }
        .nav-link:hover { background: var(--surface-2); color: var(--ink); }

        .nav-actions { display: flex; gap: 10px; margin-left: auto; align-items: center; }
        .btn-ghost {
            padding: 9px 20px; border-radius: 10px;
            font-size: 15px; font-weight: 600; color: var(--ink);
            border: 1px solid var(--border-md);
            background: transparent;
            text-decoration: none;
            transition: all .2s cubic-bezier(.4,0,.2,1);
        }
        .btn-ghost:hover {
            background: var(--surface-2);
            transform: translateY(-1px);
        }
        .btn-primary {
            padding: 9px 24px; border-radius: 10px;
            font-size: 15px; font-weight: 600; color: white;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            text-decoration: none;
            transition: all .2s cubic-bezier(.4,0,.2,1);
            box-shadow: 0 2px 8px rgba(37,99,235,.2), 0 1px 2px rgba(0,0,0,.05);
            position: relative; overflow: hidden;
        }
        .btn-primary::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.2) 0%, transparent 100%);
            opacity: 0; transition: opacity .2s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(37,99,235,.3); }
        .btn-primary:hover::before { opacity: 1; }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center;
            padding: 120px 32px 80px;
            background: linear-gradient(180deg, var(--hero-bg-start) 0%, var(--hero-bg-end) 100%);
            position: relative; overflow: hidden;
            transition: background .3s ease;
        }
        .hero-gradient {
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 800px 600px at 50% 0%, rgba(37,99,235,.08) 0%, transparent 50%),
                radial-gradient(ellipse 600px 500px at 0% 100%, rgba(124,58,237,.06) 0%, transparent 50%),
                radial-gradient(ellipse 600px 500px at 100% 100%, rgba(5,150,105,.06) 0%, transparent 50%);
        }
        [data-theme="dark"] .hero-gradient {
            background:
                radial-gradient(ellipse 800px 600px at 50% 0%, rgba(37,99,235,.12) 0%, transparent 50%),
                radial-gradient(ellipse 600px 500px at 0% 100%, rgba(124,58,237,.1) 0%, transparent 50%),
                radial-gradient(ellipse 600px 500px at 100% 100%, rgba(5,150,105,.08) 0%, transparent 50%);
        }
        .hero-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: .4;
            pointer-events: none;
        }
        [data-theme="dark"] .hero-shape { opacity: .2; }
        .shape-1 {
            width: 400px; height: 400px;
            background: linear-gradient(135deg, rgba(37,99,235,.3) 0%, rgba(124,58,237,.2) 100%);
            top: -100px; left: -100px;
            animation: float 20s ease-in-out infinite;
        }
        .shape-2 {
            width: 350px; height: 350px;
            background: linear-gradient(135deg, rgba(124,58,237,.25) 0%, rgba(5,150,105,.2) 100%);
            bottom: -80px; right: -80px;
            animation: float 18s ease-in-out infinite reverse;
        }
        .shape-3 {
            width: 300px; height: 300px;
            background: linear-gradient(135deg, rgba(5,150,105,.2) 0%, rgba(37,99,235,.25) 100%);
            top: 40%; right: 10%;
            animation: float 22s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -20px) rotate(5deg); }
            66% { transform: translate(-20px, 20px) rotate(-5deg); }
        }

        .hero-content { position: relative; z-index: 2; max-width: 900px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 6px 18px 6px 6px; border-radius: 999px;
            background: var(--surface);
            border: 1px solid var(--border);
            font-size: 13px; font-weight: 600; color: var(--ink);
            margin-bottom: 32px;
            animation: fadeUp .8s ease both;
            box-shadow: 0 2px 8px rgba(0,0,0,.04), inset 0 1px 0 rgba(255,255,255,.9);
            transition: background .3s, border-color .3s, color .3s;
        }
        [data-theme="dark"] .hero-badge { box-shadow: 0 2px 8px rgba(0,0,0,.3); }
        .badge-icon {
            width: 28px; height: 28px; border-radius: 999px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--purple) 100%);
            display: flex; align-items: center; justify-content: center;
            animation: pulse 2s ease-in-out infinite;
        }
        .badge-icon svg { width: 14px; height: 14px; color: white; }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: .9; }
        }

        .hero-title {
            font-size: clamp(42px, 7vw, 84px);
            font-weight: 900; line-height: 1.05;
            letter-spacing: -.04em;
            color: var(--ink);
            margin: 0 0 28px;
            animation: fadeUp .8s .1s ease both;
            transition: color .3s;
        }
        .hero-gradient-text {
            background: linear-gradient(135deg, var(--accent) 0%, var(--purple) 50%, var(--green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
        }
        .hero-subtitle {
            font-size: clamp(18px, 2.5vw, 22px);
            color: var(--ink-2);
            line-height: 1.6;
            max-width: 680px;
            margin: 0 auto 44px;
            font-weight: 400;
            animation: fadeUp .8s .2s ease both;
            transition: color .3s;
        }
        .hero-actions {
            display: flex; gap: 14px; justify-content: center;
            flex-wrap: wrap;
            animation: fadeUp .8s .3s ease both;
        }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 16px 32px; border-radius: 12px;
            font-size: 16px; font-weight: 700; color: white;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            text-decoration: none;
            transition: all .3s cubic-bezier(.4,0,.2,1);
            box-shadow: 0 4px 16px rgba(37,99,235,.25), 0 2px 4px rgba(0,0,0,.05);
            position: relative; overflow: hidden;
        }
        .btn-hero-primary::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,.2) 0%, transparent 100%);
            opacity: 0; transition: opacity .3s;
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,.35); }
        .btn-hero-primary:hover::before { opacity: 1; }
        .btn-hero-primary svg { width: 18px; height: 18px; }
        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 16px 32px; border-radius: 12px;
            font-size: 16px; font-weight: 600; color: var(--ink);
            background: var(--surface);
            border: 1px solid var(--border-md);
            text-decoration: none;
            transition: all .3s cubic-bezier(.4,0,.2,1);
            box-shadow: 0 1px 2px rgba(0,0,0,.04);
        }
        .btn-hero-secondary:hover {
            background: var(--surface-2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── FEATURES ── */
        .section {
            padding: 120px 32px;
            max-width: 1280px;
            margin: 0 auto;
        }
        .section-full {
            padding: 120px 32px;
            background: var(--section-alt);
            transition: background .3s;
        }
        .section-full > .section-inner {
            max-width: 1280px;
            margin: 0 auto;
        }
        .section-header { text-align: center; margin-bottom: 72px; }
        .section-label {
            font-size: 13px; font-weight: 700;
            letter-spacing: .08em; text-transform: uppercase;
            color: var(--accent); display: block; margin-bottom: 16px;
        }
        .section-title {
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 800; letter-spacing: -.03em;
            color: var(--ink); margin: 0 0 20px; line-height: 1.1;
            transition: color .3s;
        }
        .section-subtitle {
            font-size: 19px; color: var(--ink-2);
            max-width: 640px; margin: 0 auto;
            line-height: 1.6; font-weight: 400;
            transition: color .3s;
        }

        /* Feature grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
        }
        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px;
            position: relative; overflow: hidden;
            transition: all .3s cubic-bezier(.4,0,.2,1);
        }
        .feature-card::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(37,99,235,.02) 0%, transparent 100%);
            opacity: 0; transition: opacity .3s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,.08); border-color: var(--border-md); }
        .feature-card:hover::before { opacity: 1; }
        [data-theme="dark"] .feature-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,.4); }

        .fc-1 { grid-column: span 7; }
        .fc-2 { grid-column: span 5; }
        .fc-3 { grid-column: span 4; }
        .fc-4 { grid-column: span 4; }
        .fc-5 { grid-column: span 4; }
        @media (max-width: 900px) {
            .fc-1, .fc-2, .fc-3, .fc-4, .fc-5 { grid-column: span 12; }
        }

        .feature-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px; position: relative;
        }
        .feature-icon svg { width: 24px; height: 24px; position: relative; z-index: 1; }
        .fi-blue { background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%); color: var(--accent); }
        .fi-green { background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%); color: var(--green); }
        .fi-purple { background: linear-gradient(135deg, #EDE9FE 0%, #DDD6FE 100%); color: var(--purple); }
        .fi-amber { background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); color: var(--amber); }
        [data-theme="dark"] .fi-blue { background: rgba(37,99,235,.2); color: #60A5FA; }
        [data-theme="dark"] .fi-green { background: rgba(5,150,105,.2); color: #34D399; }
        [data-theme="dark"] .fi-purple { background: rgba(124,58,237,.2); color: #A78BFA; }
        [data-theme="dark"] .fi-amber { background: rgba(217,119,6,.2); color: #FCD34D; }

        .feature-title {
            font-size: 20px; font-weight: 700; color: var(--ink);
            margin: 0 0 12px; letter-spacing: -.01em;
            transition: color .3s;
        }
        .feature-description {
            font-size: 15px; color: var(--ink-2);
            line-height: 1.6; margin: 0;
            transition: color .3s;
        }

        /* Status preview */
        .status-preview { margin-top: 28px; display: flex; flex-direction: column; gap: 10px; }
        .status-row {
            display: flex; align-items: center; justify-content: space-between;
            background: var(--surface-2); border-radius: 10px; padding: 14px 16px;
            transition: all .2s;
        }
        .status-row:hover { background: var(--surface-3); transform: translateX(4px); }
        .status-info { display: flex; flex-direction: column; gap: 4px; }
        .status-room { font-weight: 700; color: var(--ink); font-family: var(--mono); font-size: 14px; transition: color .3s; }
        .status-type { color: var(--ink-3); font-size: 12px; }
        .status-badge { padding: 5px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .status-available { background: var(--green-bg); color: var(--green); }
        .status-occupied { background: var(--red-bg); color: var(--red); }
        .status-maintenance { background: var(--amber-bg); color: var(--amber); }

        /* Dark feature card */
        .feature-dark {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border-color: rgba(255,255,255,.1);
        }
        [data-theme="dark"] .feature-dark {
            background: linear-gradient(135deg, #060605 0%, #0F0E09 100%);
            border-color: rgba(255,255,255,.07);
        }
        .feature-dark .feature-title { color: white; }
        .feature-dark .feature-description { color: #94A3B8; }

        /* Mini chart */
        .mini-chart {
            display: flex; align-items: flex-end; gap: 12px;
            height: 100px; margin-top: 28px; padding: 20px;
            background: rgba(255,255,255,.05); border-radius: 12px;
            border: 1px solid rgba(255,255,255,.08);
        }
        .chart-bar { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; }
        .bar { width: 100%; border-radius: 6px 6px 0 0; transition: all .3s; }
        .bar-blue { background: linear-gradient(180deg, #3B82F6 0%, #2563EB 100%); }
        .bar-green { background: linear-gradient(180deg, #10B981 0%, #059669 100%); }
        .bar-red { background: linear-gradient(180deg, #EF4444 0%, #DC2626 100%); }
        .bar-amber { background: linear-gradient(180deg, #F59E0B 0%, #D97706 100%); }
        .chart-label { font-size: 11px; color: #64748B; font-weight: 600; }

        /* Role badges */
        .role-badges { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 24px; }
        .role-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 16px; border-radius: 999px;
            font-size: 14px; font-weight: 600; border: 1px solid;
            transition: all .2s;
        }
        .role-badge:hover { transform: translateY(-2px); }
        .role-dot { width: 8px; height: 8px; border-radius: 50%; }
        .role-admin { background: var(--accent-light); border-color: rgba(37,99,235,.2); color: var(--accent); }
        .role-admin .role-dot { background: var(--accent); }
        .role-resident { background: var(--green-bg); border-color: rgba(5,150,105,.2); color: var(--green); }
        .role-resident .role-dot { background: var(--green); }
        .role-staff { background: var(--purple-light); border-color: rgba(124,58,237,.2); color: var(--purple); }
        .role-staff .role-dot { background: var(--purple); }
        [data-theme="dark"] .role-admin { background: rgba(37,99,235,.15); border-color: rgba(37,99,235,.3); }
        [data-theme="dark"] .role-resident { background: rgba(5,150,105,.15); border-color: rgba(5,150,105,.3); }
        [data-theme="dark"] .role-staff { background: rgba(124,58,237,.15); border-color: rgba(124,58,237,.3); }

        /* Flexible room types card */
        .room-types-list { margin-top: 24px; display: flex; flex-direction: column; gap: 8px; }
        .rt-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 14px; border-radius: 10px;
            background: var(--surface-2); border: 1px solid var(--border);
            transition: all .2s;
        }
        .rt-item:hover { background: var(--surface-3); transform: translateX(4px); }
        .rt-label { font-size: 13px; font-weight: 600; color: var(--ink); font-family: var(--mono); }
        .rt-cap { font-size: 12px; color: var(--ink-3); }

        /* ── HOW IT WORKS ── */
        .steps-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 28px; margin-top: 64px;
        }
        @media (max-width: 768px) { .steps-grid { grid-template-columns: 1fr; } }
        .step {
            position: relative; padding: 40px;
            background: var(--card-bg); border: 1px solid var(--border);
            border-radius: 20px;
            transition: all .3s cubic-bezier(.4,0,.2,1);
        }
        .step:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,.08); border-color: var(--border-md); }
        [data-theme="dark"] .step:hover { box-shadow: 0 12px 40px rgba(0,0,0,.4); }
        .step-number { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: .08em; color: var(--accent); font-family: var(--mono); margin-bottom: 20px; }
        .step-title { font-size: 22px; font-weight: 700; color: var(--ink); margin: 0 0 12px; letter-spacing: -.01em; transition: color .3s; }
        .step-description { font-size: 15px; color: var(--ink-2); line-height: 1.6; margin: 0; transition: color .3s; }

        /* ── CTA ── */
        .cta-section {
            padding: 120px 32px;
            background: linear-gradient(135deg, var(--cta-bg-start) 0%, var(--cta-bg-end) 50%, var(--cta-bg-start) 100%);
            text-align: center; position: relative; overflow: hidden;
            transition: background .3s;
        }
        .cta-bg {
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 800px 600px at 30% 50%, rgba(37,99,235,.15) 0%, transparent 50%),
                radial-gradient(ellipse 600px 500px at 70% 50%, rgba(124,58,237,.12) 0%, transparent 50%);
        }
        .cta-content { position: relative; z-index: 1; max-width: 720px; margin: 0 auto; }
        .cta-title { font-size: clamp(32px, 5vw, 52px); font-weight: 800; letter-spacing: -.03em; color: white; margin: 0 0 20px; line-height: 1.1; }
        .cta-subtitle { font-size: 19px; color: #94A3B8; margin: 0 0 44px; line-height: 1.6; }
        .cta-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        /* ── FOOTER ── */
        .footer {
            background: var(--footer-bg);
            border-top: 1px solid var(--footer-border);
            padding: 48px 32px;
            transition: background .3s, border-color .3s;
        }
        .footer-inner {
            max-width: 1280px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 24px;
        }
        .footer-brand { display: flex; align-items: center; gap: 12px; }
        .footer-logo { opacity: .6; }
        .footer-text { font-size: 14px; color: var(--footer-text); transition: color .3s; }
        .footer-links { display: flex; gap: 28px; }
        .footer-link { font-size: 14px; color: var(--footer-link); text-decoration: none; transition: color .2s; }
        .footer-link:hover { color: #A3A3A3; }

        /* Scroll reveal */
        .reveal { opacity: 0; transform: translateY(30px); transition: all .8s cubic-bezier(.4,0,.2,1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="nav" id="nav">
    <div class="nav-inner">
        <a href="/" class="brand">
            <div class="logo">
                <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="10" fill="url(#logoGradient)"/>
                    <path d="M12 14h4v12h-4V14zm8 0h4v4h-4v-4zm0 6h4v6h-4v-6zm6-6h4v12h-4V14z" fill="white" opacity="0.95"/>
                    <defs>
                        <linearGradient id="logoGradient" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#2563EB"/>
                            <stop offset="1" stop-color="#7C3AED"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <span class="wordmark">Dormi<span>Hub</span></span>
        </a>
        <div class="nav-links">
            <a href="#features" class="nav-link">Features</a>
            <a href="#how-it-works" class="nav-link">How it works</a>
        </div>
        <div class="nav-actions">
            <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
                <svg class="icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg class="icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </button>
            @auth
            <a href="{{ route('dashboard') }}" class="btn-ghost">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="btn-ghost">Sign in</a>
            <a href="{{ route('register') }}" class="btn-primary">Get started</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-gradient"></div>
    <div class="hero-shape shape-1"></div>
    <div class="hero-shape shape-2"></div>
    <div class="hero-shape shape-3"></div>

    <div class="hero-content">
        <div class="hero-badge">
            <div class="badge-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            Smart Dormitory Management
        </div>

        <h1 class="hero-title">
            Manage your dorm<br>
            <span class="hero-gradient-text">rooms with clarity</span>
        </h1>

        <p class="hero-subtitle">
            DormiHub gives dormitory operators and residents a single, elegant platform to track rooms, occupancy, and pricing—beautifully simple, incredibly powerful.
        </p>

        <div class="hero-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <span>Get started — it's free</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                Sign in to dashboard
            </a>
        </div>
    </div>
</section>

<!-- Features -->
<section id="features" class="section">
    <div class="section-header">
        <span class="section-label">Features</span>
        <h2 class="section-title">Everything you need,<br>nothing you don't</h2>
        <p class="section-subtitle">A focused set of tools designed specifically for dormitory management—no bloat, no confusion, just clarity.</p>
    </div>

    <div class="features-grid">
        <!-- Feature 1: Live room status -->
        <div class="feature-card fc-1 reveal">
            <div class="feature-icon fi-blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h3 class="feature-title">Live room status</h3>
            <p class="feature-description">See every room's status at a glance—available, occupied, or under maintenance. Real-time updates keep everyone informed.</p>
            <div class="status-preview">
                <div class="status-row">
                    <div class="status-info">
                        <div class="status-room">101</div>
                        <div class="status-type">Single</div>
                    </div>
                    <span class="status-badge status-available">Available</span>
                </div>
                <div class="status-row">
                    <div class="status-info">
                        <div class="status-room">102</div>
                        <div class="status-type">Single</div>
                    </div>
                    <span class="status-badge status-occupied">Occupied</span>
                </div>
                <div class="status-row">
                    <div class="status-info">
                        <div class="status-room">103</div>
                        <div class="status-type">Single</div>
                    </div>
                    <span class="status-badge status-maintenance">Maintenance</span>
                </div>
            </div>
        </div>

        <!-- Feature 2: Dashboard analytics -->
        <div class="feature-card feature-dark fc-2 reveal">
            <div class="feature-icon" style="background: rgba(37,99,235,.2); color: #60A5FA;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="feature-title">Dashboard analytics</h3>
            <p class="feature-description">Track total rooms, occupancy rate, and availability metrics from a single, clean dashboard designed for clarity.</p>
            <div class="mini-chart">
                <div class="chart-bar">
                    <div class="bar bar-blue" style="height: 80px;"></div>
                    <span class="chart-label">Total</span>
                </div>
                <div class="chart-bar">
                    <div class="bar bar-green" style="height: 52px;"></div>
                    <span class="chart-label">Available</span>
                </div>
                <div class="chart-bar">
                    <div class="bar bar-red" style="height: 24px;"></div>
                    <span class="chart-label">Occupied</span>
                </div>
                <div class="chart-bar">
                    <div class="bar bar-amber" style="height: 12px;"></div>
                    <span class="chart-label">Maintenance</span>
                </div>
            </div>
        </div>

        <!-- Feature 3: Role-based access -->
        <div class="feature-card fc-3 reveal">
            <div class="feature-icon fi-purple">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h3 class="feature-title">Role-based access</h3>
            <p class="feature-description">Admins manage everything. Residents view their room details. Simple, secure, effective permissions.</p>
            <div class="role-badges">
                <span class="role-badge role-admin"><span class="role-dot"></span>Admin</span>
                <span class="role-badge role-staff"><span class="role-dot"></span>Staff</span>
                <span class="role-badge role-resident"><span class="role-dot"></span>Resident</span>
            </div>
        </div>

        <!-- Feature 4: Flexible room types -->
        <div class="feature-card fc-4 reveal">
            <div class="feature-icon fi-amber">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                </svg>
            </div>
            <h3 class="feature-title">Flexible room types</h3>
            <p class="feature-description">Single, double, or dormitory—manage any configuration with custom capacity settings.</p>
            <div class="room-types-list">
                <div class="rt-item"><span class="rt-label">Single</span><span class="rt-cap">1 person per room</span></div>
            </div>
        </div>

        <!-- Feature 5: Web-based -->
        <div class="feature-card fc-5 reveal">
            <div class="feature-icon fi-green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
            </div>
            <h3 class="feature-title">100% web-based</h3>
            <p class="feature-description">No installs, no downloads. Access DormiHub from any device, anywhere. Just a browser and you're ready.</p>
        </div>
    </div>
</section>

<!-- How it works -->
<div class="section-full" id="how-it-works">
    <div class="section-inner">
        <div class="section-header">
            <span class="section-label">How it works</span>
            <h2 class="section-title">Up and running<br>in minutes</h2>
            <p class="section-subtitle">No complex setup. No training needed. Three simple steps to a fully managed dormitory.</p>
        </div>
        <div class="steps-grid">
            <div class="step reveal">
                <span class="step-number">01 — REGISTER</span>
                <h3 class="step-title">Create your account</h3>
                <p class="step-description">Sign up in seconds. Your account starts with resident access—admins can be assigned by the system administrator.</p>
            </div>
            <div class="step reveal">
                <span class="step-number">02 — ADD ROOMS</span>
                <h3 class="step-title">Populate your rooms</h3>
                <p class="step-description">Admins can add rooms with a number, type, capacity, price, and status. Each room gets its own detail page instantly.</p>
            </div>
            <div class="step reveal">
                <span class="step-number">03 — MANAGE</span>
                <h3 class="step-title">Track and update</h3>
                <p class="step-description">Update room statuses as tenants move in and out. The dashboard always shows you the current state of every room.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-bg"></div>
    <div class="cta-content">
        <h2 class="cta-title">Ready to simplify your dorm management?</h2>
        <p class="cta-subtitle">Join DormiHub today. Free to get started, easy to use, built for clarity.</p>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <span>Create your account</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">Already have an account</a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="logo footer-logo">
                <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="10" fill="url(#logoGradient2)"/>
                    <path d="M12 14h4v12h-4V14zm8 0h4v4h-4v-4zm0 6h4v6h-4v-6zm6-6h4v12h-4V14z" fill="white" opacity="0.95"/>
                    <defs>
                        <linearGradient id="logoGradient2" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#2563EB"/>
                            <stop offset="1" stop-color="#7C3AED"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <span class="footer-text">© {{ date('Y') }} DormiHub. All rights reserved.</span>
        </div>
        <div class="footer-links">
            <a href="{{ route('login') }}" class="footer-link">Sign in</a>
            <a href="{{ route('register') }}" class="footer-link">Register</a>
        </div>
    </div>
</footer>

<script>
    // ── Theme toggle ──
    const html = document.documentElement;
    const toggleBtn = document.getElementById('themeToggle');
    const saved = localStorage.getItem('dormihub-theme');
    if (saved) html.setAttribute('data-theme', saved);

    toggleBtn.addEventListener('click', () => {
        const current = html.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('dormihub-theme', next);
    });

    // ── Navigation scroll ──
    const nav = document.getElementById('nav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.pageYOffset > 50);
    }, { passive: true });

    // ── Scroll reveal ──
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // ── Smooth scroll ──
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
</script>
</body>
</html>