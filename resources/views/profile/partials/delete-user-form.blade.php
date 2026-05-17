<div class="card">
    <div class="card-header">
        <div class="card-icon danger">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <div>
            <p class="card-title">Delete Account</p>
            <p class="card-subtitle">Once deleted, all data will be permanently removed.</p>
        </div>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="field">
                <label for="delete_password" class="field-label">Enter your password to confirm</label>
                <input id="delete_password" name="password" type="password" class="field-input" placeholder="Current password" required>
                @error('password', 'userDeletion')<p class="field-error">⚠️ {{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn btn-danger">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Delete Account
            </button>
        </form>
    </div>
</div>