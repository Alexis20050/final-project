<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DormiHub – {{ $title ?? 'Authentication' }}</title>
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

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: var(--font);
            background: linear-gradient(145deg, #F8F7F2 0%, #EFEDE5 100%);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Auth container */
        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }

        .auth-card {
            max-width: 460px;
            width: 100%;
            background: var(--surface);
            border-radius: 28px;
            box-shadow: 0 20px 35px -12px rgba(0,0,0,0.1);
            border: 1px solid var(--border);
            padding: 2rem 1.8rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .auth-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 40px -14px rgba(0,0,0,0.12);
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 2rem;
            text-decoration: none;
        }

        .auth-logo-icon {
            width: 36px;
            height: 36px;
            background: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--mono);
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
        }

        .auth-logo-text {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: var(--ink);
        }

        .auth-logo-text span {
            color: var(--accent);
        }

        .auth-title {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .auth-sub {
            text-align: center;
            font-size: 0.9rem;
            color: var(--ink-2);
            margin-bottom: 1.8rem;
        }

        /* Form elements */
        .input-group {
            margin-bottom: 1.2rem;
        }

        .input-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--ink-2);
            margin-bottom: 0.4rem;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            font-family: var(--font);
            font-size: 0.9rem;
            border: 1px solid var(--border-md);
            border-radius: 12px;
            background: var(--surface);
            transition: 0.15s ease;
            color: var(--ink);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }

        .input-error {
            color: var(--red);
            font-size: 0.75rem;
            margin-top: 0.3rem;
            display: block;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .checkbox-wrapper input {
            width: 1rem;
            height: 1rem;
            accent-color: var(--accent);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.8rem 1rem;
            background: var(--accent);
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: var(--accent-2);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26,86,219,0.25);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: var(--ink-3);
        }

        .auth-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert-success {
            background: var(--green-bg);
            border-left: 4px solid var(--green);
            padding: 0.8rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            color: var(--green);
            margin-bottom: 1.5rem;
        }

        .alert-status {
            background: #EFF6FF;
            border-left: 4px solid var(--accent);
            padding: 0.8rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
        }

        hr {
            margin: 1.2rem 0;
            border: none;
            border-top: 1px solid var(--border);
        }

        .inline-link {
            font-size: 0.8rem;
            color: var(--accent);
            text-decoration: none;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <a href="/" class="auth-logo">
                <div class="auth-logo-icon">D</div>
                <div class="auth-logo-text">Dormi<span>Hub</span></div>
            </a>

            {{ $slot }}
        </div>
    </div>
</body>
</html>