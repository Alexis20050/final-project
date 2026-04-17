<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:10px;">
            <h2 class="page-header-title">About DormiHub</h2>
        </div>
    </x-slot>

    <style>
        .about-hero {
            background: linear-gradient(135deg, var(--surface) 0%, var(--surface-2) 100%);
            border-radius: var(--r3);
            padding: 60px 32px;
            text-align: center;
            margin-bottom: 48px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }
        .about-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--accent-light) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0.4;
            pointer-events: none;
        }
        .logo-large {
            width: 100px;
            height: 100px;
            background: var(--accent);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 12px 24px -8px rgba(26,86,219,0.3);
            position: relative;
            z-index: 2;
        }
        .logo-large span {
            font-size: 48px;
            font-weight: 800;
            color: #fff;
            font-family: var(--mono);
        }
        .about-title {
            font-size: 36px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--text), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0 0 8px;
            letter-spacing: -0.02em;
        }
        .about-version {
            font-size: 14px;
            color: var(--text-3);
            margin-bottom: 20px;
        }
        .about-description {
            max-width: 720px;
            margin: 0 auto;
            font-size: 16px;
            line-height: 1.7;
            color: var(--text-2);
        }

        .stats-grid-about {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin: 48px 0;
        }
        @media (max-width: 640px) {
            .stats-grid-about { grid-template-columns: 1fr; gap: 16px; }
        }
        .stat-card-about {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 28px 20px;
            text-align: center;
            transition: all 0.2s;
        }
        .stat-card-about:hover {
            transform: translateY(-4px);
            border-color: var(--border-md);
            box-shadow: var(--shadow);
        }
        .stat-number-about {
            font-size: 42px;
            font-weight: 800;
            color: var(--accent);
            font-family: var(--mono);
            line-height: 1;
        }
        .stat-label-about {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-2);
            margin-top: 8px;
        }
        .stat-sub {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 4px;
        }

        .mission-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin: 48px 0;
        }
        @media (max-width: 768px) {
            .mission-section { grid-template-columns: 1fr; }
        }
        .mission-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 28px;
            transition: 0.2s;
        }
        .mission-card:hover {
            border-color: var(--border-md);
            box-shadow: var(--shadow);
        }
        .mission-icon {
            width: 48px;
            height: 48px;
            background: var(--accent-light);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .mission-icon svg {
            width: 24px;
            height: 24px;
            color: var(--accent);
        }
        .mission-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text);
        }
        .mission-text {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-2);
        }

        .features-grid-about {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 32px 0 48px;
        }
        .feature-card-about {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 20px;
            transition: 0.2s;
        }
        .feature-card-about:hover {
            transform: translateY(-2px);
            border-color: var(--border-md);
            box-shadow: var(--shadow);
        }
        .feature-icon {
            font-size: 28px;
            margin-bottom: 12px;
        }
        .feature-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text);
        }
        .feature-desc {
            font-size: 13px;
            line-height: 1.5;
            color: var(--text-2);
        }

        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin: 32px 0;
        }
        .tech-badge {
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-2);
            transition: all 0.2s;
        }
        .tech-badge:hover {
            background: var(--accent-light);
            color: var(--accent);
            border-color: var(--accent);
        }

        .roadmap-section {
            margin: 48px 0;
        }
        .roadmap-item {
            display: flex;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }
        .roadmap-status {
            width: 80px;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 40px;
            text-align: center;
            height: fit-content;
        }
        .status-live {
            background: var(--green-bg);
            color: var(--green);
        }
        .status-planned {
            background: var(--surface-2);
            color: var(--text-3);
        }
        .roadmap-title {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 4px;
        }
        .roadmap-desc {
            font-size: 13px;
            color: var(--text-2);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 24px;
            margin: 32px 0;
        }
        .team-member {
            text-align: center;
            padding: 20px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            transition: 0.2s;
        }
        .team-member:hover {
            transform: translateY(-4px);
            border-color: var(--border-md);
            box-shadow: var(--shadow);
        }
        .team-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent), #7C3AED);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 28px;
            font-weight: 600;
            color: #fff;
        }
        .team-name {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }
        .team-role {
            font-size: 12px;
            color: var(--text-3);
        }
    </style>

    <!-- Hero Section -->
    <div class="about-hero">
        <div class="logo-large">
            <span>D</span>
        </div>
        <h1 class="about-title">DormiHub</h1>
        <p class="about-version">Version 1.0</p>
        <p class="about-description">
            DormiHub is a comprehensive dormitory room allocation and management system designed for schools and universities.
            It streamlines room assignments, maintenance requests, and resident tracking – all in one beautiful, intuitive platform.
        </p>
    </div>

    <!-- Stats -->
    <div class="stats-grid-about">
        <div class="stat-card-about">
            <div class="stat-number-about">3</div>
            <div class="stat-label-about">User Roles</div>
            <div class="stat-sub">Admin · Staff · Resident</div>
        </div>
        <div class="stat-card-about">
            <div class="stat-number-about">5</div>
            <div class="stat-label-about">Core Modules</div>
            <div class="stat-sub">Rooms · Applications · Allocations · Maintenance · Reports</div>
        </div>
        <div class="stat-card-about">
            <div class="stat-number-about">∞</div>
            <div class="stat-label-about">Scalable</div>
            <div class="stat-sub">Unlimited rooms & residents</div>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="mission-section">
        <div class="mission-card">
            <div class="mission-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 3v16.5m16.5-16.5v16.5M12 6.75h7.5M12 12h7.5M12 17.25h7.5M3.75 6.75h1.5m-1.5 5.25h1.5m-1.5 5.25h1.5"/></svg>
            </div>
            <div class="mission-title">Our Mission</div>
            <div class="mission-text">To simplify dormitory management for educational institutions, providing a seamless experience for students, staff, and administrators while ensuring transparency and efficiency.</div>
        </div>
        <div class="mission-card">
            <div class="mission-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="mission-title">Our Vision</div>
            <div class="mission-text">To become the leading dormitory management platform in the Philippines, empowering schools with modern, easy‑to‑use tools for housing administration.</div>
        </div>
    </div>

    <!-- Key Features -->
    <h3 class="section-title">Key Features</h3>
    <div class="features-grid-about">
        <div class="feature-card-about"><div class="feature-icon">🏠</div><div class="feature-title">Room Management</div><div class="feature-desc">Full CRUD with images, status tracking, and building assignment.</div></div>
        <div class="feature-card-about"><div class="feature-icon">📝</div><div class="feature-title">Room Applications</div><div class="feature-desc">Students request rooms; admin approves/rejects with notes.</div></div>
        <div class="feature-card-about"><div class="feature-icon">🔑</div><div class="feature-title">Allocation System</div><div class="feature-desc">Automatic or manual room assignment with move‑in/out dates.</div></div>
        <div class="feature-card-about"><div class="feature-icon">🛠️</div><div class="feature-title">Maintenance Requests</div><div class="feature-desc">Residents report issues; staff update status and resolve.</div></div>
        <div class="feature-card-about"><div class="feature-icon">📊</div><div class="feature-title">Analytics & Reports</div><div class="feature-desc">Occupancy rates, maintenance summaries, allocation history.</div></div>
        <div class="feature-card-about"><div class="feature-icon">🔐</div><div class="feature-title">Role-Based Access</div><div class="feature-desc">Secure separation of admin, staff, and student permissions.</div></div>
    </div>

    <!-- Tech Stack -->
    <h3 class="section-title">Built With Modern Tools</h3>
    <div class="tech-stack">
        <span class="tech-badge">Laravel 12</span>
        <span class="tech-badge">PHP 8.2</span>
        <span class="tech-badge">MySQL / MariaDB</span>
        <span class="tech-badge">Tailwind CSS</span>
        <span class="tech-badge">Alpine.js</span>
        <span class="tech-badge">Vite</span>
    </div>

    <!-- Roadmap (optional) -->
    <h3 class="section-title">Roadmap</h3>
    <div class="roadmap-section">
        <div class="roadmap-item">
            <div class="roadmap-status status-live">Live</div>
            <div><div class="roadmap-title">Room Management & Allocation</div><div class="roadmap-desc">Complete CRUD for rooms, building assignment, and allocation tracking.</div></div>
        </div>
        <div class="roadmap-item">
            <div class="roadmap-status status-live">Live</div>
            <div><div class="roadmap-title">Maintenance Requests</div><div class="roadmap-desc">Students can report issues; staff can update status.</div></div>
        </div>
        <div class="roadmap-item">
            <div class="roadmap-status status-planned">Planned</div>
            <div><div class="roadmap-title">Payment Integration</div><div class="roadmap-desc">Online payment tracking and receipts for monthly rent.</div></div>
        </div>
        <div class="roadmap-item">
            <div class="roadmap-status status-planned">Planned</div>
            <div><div class="roadmap-title">Email Notifications</div><div class="roadmap-desc">Automated emails for approval, maintenance updates, and move‑in reminders.</div></div>
        </div>
    </div>

    <!-- Team -->
    <h3 class="section-title">Development Team</h3>
    <div class="team-grid">
        <div class="team-member">
            <div class="team-avatar">AP</div>
            <div class="team-name">Alexis Palicte</div>
            <div class="team-role">Lead Developer</div>
        </div>
        <!-- Add more team members if needed -->
    </div>

    <!-- Footer -->
    <div style="text-align: center; margin-top: 48px; padding-top: 24px; border-top: 1px solid var(--border);">
        <p style="color: var(--text-3); font-size: 13px;">&copy; {{ date('Y') }} DormiHub – All rights reserved.</p>
        <p style="color: var(--text-3); font-size: 12px; margin-top: 8px;">Empowering dormitory management for educational institutions.</p>
    </div>
</x-app-layout>