<x-guest-layout>
    <div class="auth-title">Welcome back</div>
    <div class="auth-sub">Sign in to your DormiHub account</div>

    <x-auth-session-status class="alert-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
            <label for="email" class="input-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="input-field" required autofocus autocomplete="username">
            @error('email') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <label for="password" class="input-label">Password</label>
            <input id="password" type="password" name="password" class="input-field" required autocomplete="current-password">
            @error('password') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <div class="checkbox-wrapper">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me" style="font-size: 0.85rem; color: var(--ink-2);">Remember me</label>
        </div>

        <div class="flex-between" style="margin-top: 0.5rem;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="inline-link">Forgot password?</a>
            @endif
            <button type="submit" class="btn-primary" style="width: auto; padding: 0.6rem 1.4rem;">Log in</button>
        </div>
    </form>

    <div class="auth-footer">
        Don’t have an account? <a href="{{ route('register') }}">Create one</a>
    </div>
</x-guest-layout>   