<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="back-btn" style="display:flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:7px; border:1px solid var(--border-md); background:var(--surface); color:var(--text-2); text-decoration:none; transition:background .12s;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">User Details: {{ $user->name }}</h2>
        </div>
    </x-slot>

    <style>
        .detail-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 24px;
            margin-bottom: 24px;
        }
        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }
        .detail-label {
            width: 150px;
            font-weight: 600;
            color: var(--text-2);
        }
        .detail-value {
            flex: 1;
            color: var(--text);
        }
        .allocation-item {
            background: var(--surface-2);
            border-radius: var(--r);
            padding: 12px;
            margin-bottom: 12px;
        }
        .text-muted {
            color: var(--text-3);
        }
        .text-lg {
            font-size: 1.125rem;
        }
        .font-semibold {
            font-weight: 600;
        }
        .mb-4 {
            margin-bottom: 1rem;
        }
    </style>

    <div class="detail-card">
        <div class="detail-row">
            <div class="detail-label">Full Name</div>
            <div class="detail-value">{{ $user->name }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Email</div>
            <div class="detail-value">{{ $user->email }}</div>
        </div>
        {{-- Student ID row removed --}}
        {{-- Phone row removed --}}
        <div class="detail-row">
            <div class="detail-label">Role</div>
            <div class="detail-value">{{ ucfirst($user->role) }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Member Since</div>
            <div class="detail-value">{{ $user->created_at->format('F d, Y') }}</div>
        </div>
    </div>

    <div class="detail-card">
        <h3 class="text-lg font-semibold mb-4">Room Allocation History</h3>
        @forelse($user->allocations as $alloc)
            <div class="allocation-item">
                <div><strong>Room:</strong> {{ $alloc->room->room_number }} ({{ ucfirst($alloc->room->type) }})</div>
                <div><strong>Period:</strong> 
                    {{ \Carbon\Carbon::parse($alloc->start_date)->format('M d, Y') }} 
                    @if($alloc->end_date)
                        – {{ \Carbon\Carbon::parse($alloc->end_date)->format('M d, Y') }}
                    @else
                        – Present
                    @endif
                </div>
                <div><strong>Status:</strong> {{ ucfirst($alloc->status) }}</div>
            </div>
        @empty
            <p class="text-muted">No allocation records.</p>
        @endforelse
    </div>
</x-app-layout>