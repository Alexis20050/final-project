<x-guest-layout>
    <div class="auth-title">Create account</div>
    <div class="auth-sub">Start managing your dormitory today</div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group">
            <label for="name" class="input-label">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="input-field" required autofocus autocomplete="name">
            @error('name') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <label for="email" class="input-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="input-field" required autocomplete="username">
            @error('email') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <label for="password" class="input-label">Password</label>
            <input id="password" type="password" name="password" class="input-field" required autocomplete="new-password">
            @error('password') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <label for="password_confirmation" class="input-label">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="input-field" required autocomplete="new-password">
            @error('password_confirmation') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-primary">Register</button>
    </form>

    <div class="auth-footer">
        Already registered? <a href="{{ route('login') }}">Sign in</a>
    </div>
</x-guest-layout>