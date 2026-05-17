<div class="card">
    <div class="card-header">
        <div class="card-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <p class="card-title">Profile Information</p>
            <p class="card-subtitle">Update your name and email address.</p>
        </div>
    </div>
    <div class="card-body">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="field">
                <label for="name" class="field-label">Name</label>
                <input id="name" name="name" type="text" class="field-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')<p class="field-error">⚠️ {{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label for="email" class="field-label">Email</label>
                <input id="email" name="email" type="email" class="field-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')<p class="field-error">⚠️ {{ $message }}</p>@enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning" style="margin-top: 12px;">
                        Your email address is unverified.
                        <button form="send-verification" style="background:none; border:none; color:var(--amber); font-weight:600; cursor:pointer; text-decoration:underline; margin-left:4px;">
                            Resend verification email
                        </button>
                    </div>
                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success">A new verification link has been sent.</div>
                    @endif
                @endif
            </div>

            <div style="display:flex; align-items:center; gap:12px;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save
                </button>
                @if (session('status') === 'profile-updated')
                    <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="font-size:13px; color:var(--green);">Saved.</span>
                @endif
            </div>
        </form>
    </div>
</div>