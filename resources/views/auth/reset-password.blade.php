<x-guest-layout>
    <div class="auth-title">Reset password</div>
    <div class="auth-sub">Choose a new password for your account</div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="input-group">
            <label for="email" class="input-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" class="input-field" required autofocus autocomplete="username">
            @error('email') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <label for="password" class="input-label">New password</label>
            <input id="password" type="password" name="password" class="input-field" required autocomplete="new-password">
            @error('password') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <div class="input-group">
            <label for="password_confirmation" class="input-label">Confirm new password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="input-field" required autocomplete="new-password">
            @error('password_confirmation') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-primary">Reset password</button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('login') }}">Back to login</a>
    </div>
</x-guest-layout>