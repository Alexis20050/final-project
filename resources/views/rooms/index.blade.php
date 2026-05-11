<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; align-items:center; justify-content:space-between; width:100%; gap:12px; flex-wrap:wrap;">
            <h2 class="page-header-title">Rooms</h2>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('rooms.create') }}" style="display:inline-flex; align-items:center; gap:7px; padding:7px 15px; background:var(--accent); color:#fff; border-radius:var(--r); font-size:13px; font-weight:500; text-decoration:none; box-shadow:0 1px 4px rgba(26,86,219,.25); transition:opacity .15s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                Add Room
            </a>
            @endif
        </div>
    </x-slot>

    <style>
        /* ── Alerts ── */
        .alert {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: var(--r);
            font-size: 14px; margin-bottom: 20px;
            border: 1px solid;
        }
        .alert-success {
            background: var(--green-bg); color: var(--green);
            border-color: rgba(14,159,110,.2);
        }
        .alert-error {
            background: var(--red-bg); color: var(--red);
            border-color: rgba(224,36,36,.2);
        }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Filters ── */
        .filters {
            display: flex; gap: 6px; margin-bottom: 20px; flex-wrap: wrap;
        }
        .chip {
            padding: 6px 14px; border-radius: 99px;
            font-size: 13px; font-weight: 500;
            border: 1px solid var(--border-md);
            background: var(--surface); color: var(--text-2);
            text-decoration: none;
            transition: all .15s;
        }
        .chip:hover {
            background: var(--surface-2); color: var(--text);
            border-color: var(--border-md);
        }
        .chip.on {
            background: var(--accent); color: #fff;
            border-color: var(--accent);
            box-shadow: 0 2px 8px rgba(26,86,219,.25);
        }

        /* ── Grid ── */
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 18px;
        }
        .room-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r3);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s, border-color .2s;
            display: flex; flex-direction: column;
        }
        .room-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,.08), 0 1px 3px rgba(0,0,0,.04);
            border-color: var(--border-md);
        }

        /* Image */
        .room-img {
            width: 100%; height: 160px; object-fit: cover;
            border-bottom: 1px solid var(--border);
        }
        .room-img-placeholder {
            width: 100%; height: 160px;
            background: var(--surface-2);
            display: flex; align-items: center; justify-content: center;
            border-bottom: 1px solid var(--border);
            color: var(--text-3);
        }

        /* Body */
        .room-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
        .room-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 12px;
        }
        .room-number {
            font-size: 18px; font-weight: 700;
            color: var(--text);
            font-family: var(--mono);
            letter-spacing: -.02em;
        }
        .room-type {
            font-size: 11px; font-weight: 600;
            padding: 3px 10px; border-radius: 99px;
            background: var(--surface-2);
            color: var(--text-3);
            border: 1px solid var(--border);
            text-transform: capitalize;
        }
        .room-status {
            display: inline-block;
            padding: 3px 10px; border-radius: 99px;
            font-size: 12px; font-weight: 500;
            margin-top: 8px;
        }
        .status-available { background: var(--green-bg); color: var(--green); }
        .status-occupied  { background: var(--red-bg); color: var(--red); }
        .status-maintenance { background: var(--amber-bg); color: var(--amber); }
        .status-archived   { background: var(--surface-2); color: var(--text-3); }

        .room-details {
            display: flex; flex-direction: column; gap: 6px;
            margin: 12px 0; flex: 1;
        }
        .room-detail-row {
            display: flex; justify-content: space-between;
            font-size: 13px;
        }
        .room-detail-label { color: var(--text-3); }
        .room-detail-value { color: var(--text); font-weight: 500; }
        .room-price {
            font-size: 18px; font-weight: 700;
            color: var(--accent-tx);
            font-family: var(--mono);
        }

        .room-actions {
            display: flex; gap: 8px; margin-top: 14px;
            flex-wrap: wrap; align-items: center;
        }
        .btn-room {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: var(--r);
            font-size: 12px; font-weight: 500;
            text-decoration: none;
            transition: background .12s, color .12s;
            border: 1px solid var(--border);
        }
        .btn-room-view {
            color: var(--accent-tx);
            background: var(--surface-2);
            border-color: var(--border);
        }
        .btn-room-view:hover {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }
        .btn-room-edit {
            color: var(--text-2);
            background: var(--surface);
        }
        .btn-room-edit:hover {
            background: var(--surface-2);
            color: var(--text);
        }
        .btn-room-request {
            background: var(--green-bg);
            color: var(--green);
            border-color: var(--green);
        }
        .btn-room-request:hover {
            background: var(--green);
            color: #fff;
        }
        .btn-room-archive {
            background: var(--amber-bg);
            color: var(--amber);
            border-color: var(--amber);
        }
        .btn-room-archive:hover {
            background: var(--amber);
            color: #fff;
        }
        .btn-room-restore {
            background: var(--green-bg);
            color: var(--green);
            border-color: var(--green);
        }
        .btn-room-restore:hover {
            background: var(--green);
            color: #fff;
        }

        /* Empty state */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
        }
        .empty-state svg {
            width: 48px; height: 48px; color: var(--text-3);
            opacity: .4; margin-bottom: 16px;
        }
        .empty-state p {
            font-size: 14px; color: var(--text-2);
            margin: 0 0 16px;
        }

        /* ============================================
           CENTER THE HOME LOGO IN THE NAVIGATION BAR
           ============================================ */
        /* Target the logo container inside the main nav (app-layout) */
        nav .flex.shrink-0,
        nav [x-data] .flex.shrink-0 {
            position: absolute !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
        }
        /* Ensure the nav's parent container allows absolute positioning */
        nav > div.relative,
        nav > .max-w-7xl,
        nav > div:first-child {
            position: relative !important;
        }
        /* Remove any conflicting margins */
        nav .sm\:ml-0 {
            margin-left: 0 !important;
        }
        /* Adjust the right-side (user menu) so it doesn't overlap */
        nav .flex.items-center.gap-4,
        nav .flex.items-center.space-x-4,
        nav .flex.items-center.gap-2 {
            margin-left: auto;
        }
        /* For responsive: keep logo centered and avoid overlapping on small screens */
        @media (max-width: 640px) {
            nav .flex.shrink-0 {
                position: relative !important;
                left: auto !important;
                transform: none !important;
                margin: 0 auto !important;
            }
            nav > div:first-child {
                flex-wrap: wrap !important;
            }
        }
    </style>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="filters">
        @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
            <a href="{{ route('rooms.index') }}" class="chip {{ !request('status') && !request('archived') ? 'on' : '' }}">All</a>
            <a href="{{ route('rooms.index', ['status' => 'available']) }}" class="chip {{ request('status') === 'available' ? 'on' : '' }}">Available</a>
            <a href="{{ route('rooms.index', ['status' => 'occupied']) }}" class="chip {{ request('status') === 'occupied' ? 'on' : '' }}">Occupied</a>
            <a href="{{ route('rooms.index', ['status' => 'maintenance']) }}" class="chip {{ request('status') === 'maintenance' ? 'on' : '' }}">Maintenance</a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('rooms.index', ['archived' => 1]) }}" class="chip {{ request('archived') == 1 ? 'on' : '' }}">Archived</a>
            @endif
        @else
            <span class="chip on">Available rooms</span>
        @endif
    </div>

    {{-- Grid --}}
    <div class="room-grid">
        @forelse($rooms as $room)
            <div class="room-card">
                @if($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}" alt="Room {{ $room->room_number }}" class="room-img">
                @else
                    <div class="room-img-placeholder">
                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif

                <div class="room-body">
                    <div class="room-header">
                        <div>
                            <div class="room-number">{{ $room->room_number }}</div>
                            <span class="room-status status-{{ $room->status }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </div>
                        <span class="room-type">{{ ucfirst($room->type) }}</span>
                    </div>

                    <div class="room-details">
                        <div class="room-detail-row">
                            <span class="room-detail-label">Capacity</span>
                            <span class="room-detail-value">1 person</span>
                        </div>
                        <div class="room-detail-row">
                            <span class="room-detail-label">Price</span>
                            <span class="room-price">₱{{ number_format($room->price_per_month, 0) }}</span>
                        </div>
                        <div class="room-detail-row">
                            <span class="room-detail-label">Added</span>
                            <span class="room-detail-value">{{ $room->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="room-actions">
                        <a href="{{ route('rooms.show', $room) }}" class="btn-room btn-room-view">
                            View details →
                        </a>

                        @auth
                            @if(auth()->user()->isResident() && $room->status === 'available' && !$room->archived)
                                <form method="POST" action="{{ route('rooms.request', $room) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-room btn-room-request">Request</button>
                                </form>
                            @endif
                        @endauth

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('rooms.edit', $room) }}" class="btn-room btn-room-edit">Edit</a>
                            @if($room->archived)
                                <form method="POST" action="{{ route('rooms.restore', $room) }}" style="display:inline;"
                                      onsubmit="return confirm('Restore this room?');">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-room btn-room-restore">Restore</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('rooms.archive', $room) }}" style="display:inline;"
                                      onsubmit="return confirm('Archive this room?');">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-room btn-room-archive">Archive</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                <p>No rooms found.</p>
                @if(auth()->user()->isAdmin() && !request('archived'))
                    <a href="{{ route('rooms.create') }}" style="display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:var(--accent); color:#fff; border-radius:var(--r); font-size:13px; font-weight:500; text-decoration:none;">
                        + Add your first room
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    {{ $rooms->links('components.pagination') }}
</x-app-layout>