<x-guest-layout>
    <div class="auth-title">Confirm password</div>
    <div class="auth-sub">
        This is a secure area. Please confirm your password before continuing.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="input-group">
            <label for="password" class="input-label">Password</label>
            <input id="password" type="password" name="password" class="input-field" required autocomplete="current-password">
            @error('password') <span class="input-error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-primary">Confirm</button>
    </form>
</x-guest-layout>