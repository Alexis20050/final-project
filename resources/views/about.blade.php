<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About — DormiHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font: 'Inter', system-ui, -apple-system, sans-serif;
            --mono: 'JetBrains Mono', monospace;
            --ink: #0A0A0A;
            --ink-2: #525252;
            --ink-3: #A3A3A3;
            --surface: #FFFFFF;
            --surface-2: #FAFAFA;
            --surface-3: #F5F5F5;
            --border: rgba(0,0,0,.06);
            --border-md: rgba(0,0,0,.1);
            --accent: #2563EB;
            --accent-2: #1D4ED8;
            --accent-light: #DBEAFE;
            --green: #059669;
            --green-bg: #ECFDF5;
            --purple: #7C3AED;
            --purple-light: #F5F3FF;
            --amber: #D97706;
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
        }

        /* ── NAVIGATION ─────────────────────────────────── */
        .nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            background: rgba(255,255,255,.85);
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
        .logo svg {
            width: 100%; height: 100%;
            filter: drop-shadow(0 2px 8px rgba(37,99,235,.2));
        }
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
        .nav-link:hover {
            background: var(--surface-2);
            color: var(--ink);
        }
        .nav-link.active {
            background: var(--surface-2);
            color: var(--ink);
        }
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
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37,99,235,.3), 0 2px 4px rgba(0,0,0,.08);
        }

        /* ── HERO ─────────────────────────────────── */
        .page-hero {
            padding: 140px 32px 80px;
            background: linear-gradient(180deg, #FAFAFA 0%, #FFFFFF 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-gradient {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 800px 400px at 50% 0%, rgba(37,99,235,.06) 0%, transparent 60%);
        }
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        .hero-label {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 20px;
        }
        .hero-title {
            font-size: clamp(36px, 6vw, 64px);
            font-weight: 900;
            letter-spacing: -.04em;
            color: var(--ink);
            margin: 0 0 24px;
            line-height: 1.1;
        }
        .hero-subtitle {
            font-size: clamp(18px, 2.5vw, 22px);
            color: var(--ink-2);
            line-height: 1.6;
            margin: 0;
            font-weight: 400;
        }

        /* ── SECTIONS ─────────────────────────────────── */
        .section {
            padding: 100px 32px;
            max-width: 1280px;
            margin: 0 auto;
        }
        .section-alt {
            background: var(--surface-2);
        }

        /* Story section */
        .story-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        @media (max-width: 900px) {
            .story-grid { grid-template-columns: 1fr; gap: 40px; }
        }
        .story-content h2 {
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 800;
            letter-spacing: -.03em;
            color: var(--ink);
            margin: 0 0 24px;
            line-height: 1.15;
        }
        .story-content p {
            font-size: 17px;
            color: var(--ink-2);
            line-height: 1.7;
            margin: 0 0 20px;
        }
        .story-content p:last-child {
            margin-bottom: 0;
        }
        .story-visual {
            background: linear-gradient(135deg, #DBEAFE 0%, #E0E7FF 50%, #D1FAE5 100%);
            border-radius: 24px;
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .story-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 50%, rgba(37,99,235,.1) 0%, transparent 60%);
        }
        .story-icon {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(0,0,0,.12);
            position: relative;
            z-index: 1;
        }
        .story-icon svg {
            width: 60px;
            height: 60px;
            color: var(--accent);
        }

        /* Mission/Vision */
        .mission-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 32px;
            margin-top: 64px;
        }
        @media (max-width: 768px) {
            .mission-grid { grid-template-columns: 1fr; }
        }
        .mission-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }
        .mission-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent) 0%, var(--purple) 100%);
        }
        .mission-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }
        .mission-icon svg {
            width: 28px;
            height: 28px;
            color: var(--accent);
        }
        .mission-card h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 16px;
            letter-spacing: -.01em;
        }
        .mission-card p {
            font-size: 16px;
            color: var(--ink-2);
            line-height: 1.7;
            margin: 0;
        }

        /* Values */
        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            margin-top: 64px;
        }
        @media (max-width: 900px) {
            .values-grid { grid-template-columns: 1fr; }
        }
        .value-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            transition: all .3s cubic-bezier(.4,0,.2,1);
        }
        .value-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,.08);
            border-color: rgba(0,0,0,.12);
        }
        .value-emoji {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }
        .value-card h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 12px;
        }
        .value-card p {
            font-size: 15px;
            color: var(--ink-2);
            line-height: 1.6;
            margin: 0;
        }

        /* Stats */
        .stats-section {
            text-align: center;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: var(--border);
            border-radius: 16px;
            overflow: hidden;
            margin-top: 64px;
            box-shadow: 0 4px 24px rgba(0,0,0,.06);
        }
        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        .stat-box {
            background: white;
            padding: 40px 32px;
            text-align: center;
        }
        .stat-number {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: -.02em;
            color: var(--ink);
            font-family: var(--mono);
            display: block;
            line-height: 1;
            background: linear-gradient(135deg, var(--accent) 0%, var(--purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stat-label {
            font-size: 14px;
            color: var(--ink-3);
            margin-top: 12px;
            font-weight: 500;
        }

        /* Team section */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
            margin-top: 64px;
        }
        @media (max-width: 900px) {
            .team-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .team-grid { grid-template-columns: 1fr; }
        }
        .team-member {
            text-align: center;
        }
        .team-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--accent-light) 0%, var(--purple-light) 100%);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid white;
            box-shadow: 0 4px 16px rgba(0,0,0,.1);
        }
        .team-avatar svg {
            width: 60px;
            height: 60px;
            color: var(--accent);
        }
        .team-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 4px;
        }
        .team-role {
            font-size: 14px;
            color: var(--ink-3);
            margin: 0;
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 32px;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-bg {
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(ellipse 800px 600px at 30% 50%, rgba(37,99,235,.15) 0%, transparent 50%),
                radial-gradient(ellipse 600px 500px at 70% 50%, rgba(124,58,237,.12) 0%, transparent 50%);
        }
        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 720px;
            margin: 0 auto;
        }
        .cta-title {
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 800;
            letter-spacing: -.03em;
            color: white;
            margin: 0 0 20px;
            line-height: 1.1;
        }
        .cta-subtitle {
            font-size: 19px;
            color: #94A3B8;
            margin: 0 0 40px;
            line-height: 1.6;
        }
        .cta-actions {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            text-decoration: none;
            transition: all .3s cubic-bezier(.4,0,.2,1);
            box-shadow: 0 4px 16px rgba(37,99,235,.25);
        }
        .btn-cta-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37,99,235,.35);
        }
        .btn-cta-secondary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            text-decoration: none;
            transition: all .3s;
        }
        .btn-cta-secondary:hover {
            background: rgba(255,255,255,.15);
        }

        /* Footer */
        .footer {
            background: #0A0A0A;
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 48px 32px;
        }
        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
        }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .footer-logo { opacity: .6; }
        .footer-text {
            font-size: 14px;
            color: #525252;
        }
        .footer-links {
            display: flex;
            gap: 28px;
        }
        .footer-link {
            font-size: 14px;
            color: #737373;
            text-decoration: none;
            transition: color .2s;
        }
        .footer-link:hover { color: #A3A3A3; }

        /* Section headers */
        .section-header {
            text-align: center;
            margin-bottom: 64px;
        }
        .section-label {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--accent);
            display: block;
            margin-bottom: 16px;
        }
        .section-title {
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 800;
            letter-spacing: -.03em;
            color: var(--ink);
            margin: 0 0 20px;
            line-height: 1.1;
        }
        .section-subtitle {
            font-size: 18px;
            color: var(--ink-2);
            max-width: 640px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all .8s cubic-bezier(.4,0,.2,1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="nav">
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
            <a href="/" class="nav-link">Home</a>
            <a href="/#features" class="nav-link">Features</a>
            <a href="{{ route('about') }}" class="nav-link active">About</a>
        </div>
        <div class="nav-actions">
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
<section class="page-hero">
    <div class="hero-gradient"></div>
    <div class="hero-content">
        <div class="hero-label">About DormiHub</div>
        <h1 class="hero-title">Simplifying dormitory management for everyone</h1>
        <p class="hero-subtitle">We're building the future of dormitory operations—one room at a time. Clear, simple, and designed for real people.</p>
    </div>
</section>

<!-- Story Section -->
<section class="section">
    <div class="story-grid reveal">
        <div class="story-content">
            <h2>Built from real-world experience</h2>
            <p>DormiHub was born from a simple frustration: managing dormitory rooms shouldn't require complex spreadsheets, endless emails, or outdated software that nobody wants to use.</p>
            <p>We saw dormitory administrators struggling with fragmented systems, residents confused about availability, and pricing information scattered across multiple documents. There had to be a better way.</p>
            <p>So we built it. DormiHub brings everything into one clean, intuitive platform that anyone can use—from day one, without training, without confusion.</p>
        </div>
        <div class="story-visual">
            <div class="story-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="section section-alt">
    <div class="section-header">
        <span class="section-label">Our Mission</span>
        <h2 class="section-title">What drives us forward</h2>
        <p class="section-subtitle">We're committed to making dormitory management accessible, transparent, and efficient for institutions and residents alike.</p>
    </div>

    <div class="mission-grid">
        <div class="mission-card reveal">
            <div class="mission-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h3>Transparency First</h3>
            <p>Every room status, every price, every detail is visible and accessible. No hidden information, no confusion. Just clear, honest data that everyone can trust.</p>
        </div>

        <div class="mission-card reveal">
            <div class="mission-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3>Effortless Operation</h3>
            <p>Dormitory management should be simple, not complicated. We eliminate the friction, remove the complexity, and give you tools that just work—instantly.</p>
        </div>
    </div>
</section>

<!-- Values -->
<section class="section">
    <div class="section-header">
        <span class="section-label">Core Values</span>
        <h2 class="section-title">What we believe in</h2>
        <p class="section-subtitle">These principles guide every decision we make and every feature we build.</p>
    </div>

    <div class="values-grid">
        <div class="value-card reveal">
            <span class="value-emoji">🎯</span>
            <h4>Simplicity</h4>
            <p>We choose clarity over complexity. Every feature is designed to be immediately understandable.</p>
        </div>
        <div class="value-card reveal">
            <span class="value-emoji">⚡</span>
            <h4>Speed</h4>
            <p>Fast to learn, fast to use, fast to get results. Your time is valuable—we respect that.</p>
        </div>
        <div class="value-card reveal">
            <span class="value-emoji">🔒</span>
            <h4>Reliability</h4>
            <p>Your data is safe, your access is secure, and our platform is always available when you need it.</p>
        </div>
        <div class="value-card reveal">
            <span class="value-emoji">🎨</span>
            <h4>Design</h4>
            <p>Beautiful interfaces aren't just nice to have—they make work more enjoyable and productive.</p>
        </div>
        <div class="value-card reveal">
            <span class="value-emoji">🤝</span>
            <h4>Accessibility</h4>
            <p>Everyone should be able to manage their dormitory, regardless of technical expertise.</p>
        </div>
        <div class="value-card reveal">
            <span class="value-emoji">📈</span>
            <h4>Growth</h4>
            <p>We continuously improve based on real feedback from real users solving real problems.</p>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="section section-alt stats-section">
    <div class="section-header">
        <span class="section-label">By the Numbers</span>
        <h2 class="section-title">Built for scale</h2>
    </div>

    <div class="stats-grid reveal">
        <div class="stat-box">
            <span class="stat-number">3</span>
            <div class="stat-label">Room Categories</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">2</span>
            <div class="stat-label">Access Levels</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">∞</span>
            <div class="stat-label">Rooms Supported</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">24/7</span>
            <div class="stat-label">Platform Availability</div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="section">
    <div class="section-header">
        <span class="section-label">Our Team</span>
        <h2 class="section-title">Meet the people behind DormiHub</h2>
        <p class="section-subtitle">A dedicated team committed to making dormitory management simple and effective.</p>
    </div>

    <div class="team-grid">
        <div class="team-member reveal">
            <div class="team-avatar">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="team-name">Development Team</h3>
            <p class="team-role">Building the platform</p>
        </div>
        <div class="team-member reveal">
            <div class="team-avatar">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <h3 class="team-name">Design Team</h3>
            <p class="team-role">Crafting the experience</p>
        </div>
        <div class="team-member reveal">
            <div class="team-avatar">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="team-name">Support Team</h3>
            <p class="team-role">Here to help you</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-bg"></div>
    <div class="cta-content">
        <h2 class="cta-title">Ready to transform your dormitory management?</h2>
        <p class="cta-subtitle">Join DormiHub today and experience the difference that clarity makes.</p>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn-cta-primary">
                <span>Get started for free</span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('login') }}" class="btn-cta-secondary">
                Sign in to your account
            </a>
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
            <a href="/" class="footer-link">Home</a>
            <a href="{{ route('about') }}" class="footer-link">About</a>
            <a href="{{ route('login') }}" class="footer-link">Sign in</a>
            <a href="{{ route('register') }}" class="footer-link">Register</a>
        </div>
    </div>
</footer>

<script>
    // Scroll reveal animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => {
        observer.observe(el);
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
</body>
</html>