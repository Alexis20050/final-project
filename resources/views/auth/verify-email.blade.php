<x-guest-layout>
    <div class="auth-title">Verify your email</div>
    <div class="auth-sub">
        Thanks for signing up! Before getting started, please verify your email address.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert-success">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="auth-sub" style="margin-bottom: 1.5rem;">
        If you didn’t receive the email, click the button below and we’ll send another.
    </div>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-primary">
            Resend Verification Email
        </button>
    </form>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="inline-link" style="background: none; border: none; cursor: pointer; width: auto; display: inline; margin: 0 auto;">
            Log out
        </button>
    </form>
</x-guest-layout>