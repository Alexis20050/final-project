<div class="card">
    <div class="card-header">
        <div class="card-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <div>
            <p class="card-title">Update Password</p>
            <p class="card-subtitle">Use a long, random password to stay secure.</p>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="field">
                <label for="current_password" class="field-label">Current Password</label>
                <input id="current_password" name="current_password" type="password" class="field-input" autocomplete="current-password">
                @error('current_password', 'updatePassword')<p class="field-error">⚠️ {{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label for="password" class="field-label">New Password</label>
                <input id="password" name="password" type="password" class="field-input" autocomplete="new-password">
                @error('password', 'updatePassword')<p class="field-error">⚠️ {{ $message }}</p>@enderror
            </div>
            <div class="field">
                <label for="password_confirmation" class="field-label">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="field-input" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')<p class="field-error">⚠️ {{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Save Password
            </button>

            @if (session('status') === 'password-updated')
                <div class="alert alert-success">Password updated successfully.</div>
            @endif
        </form>
    </div>
</div>