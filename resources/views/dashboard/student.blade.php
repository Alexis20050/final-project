<x-app-layout>
    <x-slot name="header">
        <h2 class="page-header-title">Student Dashboard</h2>
    </x-slot>

    <style>
        /* reuse your existing styles from previous student dashboard */
        .badge { display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:99px;font-size:11.5px;font-weight:500; }
        .badge.available  { background:var(--green-bg);color:var(--green); }
        .badge.occupied   { background:var(--red-bg);color:var(--red); }
        .badge.maintenance{ background:var(--amber-bg);color:var(--amber); }
        .badge-pending { background:var(--amber-bg);color:var(--amber); }
        .badge-resolved { background:var(--green-bg);color:var(--green); }
        .badge-in-progress { background:var(--accent-bg);color:var(--accent); }
        .card { background:var(--surface);border:1px solid var(--border);border-radius:var(--r2);overflow:hidden; }
        .card-hd {
            display:flex;align-items:center;justify-content:space-between;
            padding:14px 20px;border-bottom:1px solid var(--border);
        }
        .card-hd-title { font-size:13.5px;font-weight:600;color:var(--text);margin:0; }
        .card-hd-link { font-size:12.5px;color:var(--accent-tx);text-decoration:none; }
        .card-hd-link:hover { text-decoration:underline; }

        .hero {
            background:#0F0E09;
            border-radius:var(--r3);
            padding:28px 32px;
            margin-bottom:24px;
            position:relative;overflow:hidden;
            border:1px solid rgba(255,255,255,.07);
        }
        .hero::before {
            content:'';position:absolute;top:-80px;right:-60px;
            width:280px;height:280px;border-radius:50%;
            background:radial-gradient(circle,rgba(26,86,219,.25) 0%,transparent 70%);
            pointer-events:none;
        }
        .hero-greeting { font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:#60A5FA;font-weight:600;margin-bottom:6px; }
        .hero-name { font-size:22px;font-weight:700;color:#F0EEE8;letter-spacing:-.4px;margin:0 0 6px; }
        .hero-sub  { font-size:13px;color:#5B5950;margin:0 0 16px;font-weight:300; }
        .hero-role {
            display:inline-flex;align-items:center;gap:6px;
            padding:4px 12px;border-radius:99px;
            background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.09);
            font-size:12px;color:#9A9890;text-transform:capitalize;
        }
        .hero-role-dot { width:6px;height:6px;border-radius:50%;background:#60A5FA; }

        .stats-grid {
            display:grid;
            grid-template-columns:repeat(4,minmax(0,1fr));
            gap:14px;
            margin-bottom:24px;
        }
        @media(max-width:900px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:480px){.stats-grid{grid-template-columns:1fr;}}

        .stat {
            background:var(--surface);border:1px solid var(--border);
            border-radius:var(--r2);padding:18px;
            transition:box-shadow .2s,border-color .2s;
        }
        .stat:hover{box-shadow:var(--shadow);border-color:var(--border-md);}
        .stat-top{display:flex;align-items:flex-start;justify-content:space-between;}
        .stat-icon{
            width:36px;height:36px;border-radius:9px;
            display:flex;align-items:center;justify-content:center;
        }
        .stat-icon svg{width:16px;height:16px;}
        .si-blue  {background:var(--accent-bg);color:var(--accent);}
        .si-green {background:var(--green-bg);color:var(--green);}
        .si-amber {background:var(--amber-bg);color:var(--amber);}
        .stat-label{font-size:11.5px;color:var(--text-3);font-weight:500;}
        .stat-val{font-size:28px;font-weight:700;letter-spacing:-.04em;line-height:1;font-family:var(--mono);}
        .stat-footer{font-size:11.5px;color:var(--text-3);margin-top:6px;}

        .room-detail-card {
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:var(--r2);
            margin-bottom:24px;
            overflow:hidden;
        }
        .room-detail-header {
            padding:14px 20px;
            border-bottom:1px solid var(--border);
            background:var(--surface-2);
        }
        .room-detail-header h3 { margin:0; font-size:14px; font-weight:600; }
        .room-detail-body { padding:20px; display:flex; gap:20px; flex-wrap:wrap; }
        .room-image { width:120px; height:120px; object-fit:cover; border-radius:var(--r); background:var(--surface-2); }
        .room-info-grid { flex:1; display:grid; grid-template-columns:repeat(2,1fr); gap:12px; }
        .room-info-item { }
        .room-info-label { font-size:11px; color:var(--text-3); text-transform:uppercase; }
        .room-info-value { font-size:15px; font-weight:600; color:var(--text); }

        .maintenance-table, .history-table {
            width:100%;
            border-collapse:collapse;
        }
        .maintenance-table th, .maintenance-table td,
        .history-table th, .history-table td {
            padding:10px 16px;
            text-align:left;
            border-bottom:1px solid var(--border);
        }
        .maintenance-table th, .history-table th {
            font-size:11px;
            font-weight:600;
            color:var(--text-3);
            text-transform:uppercase;
        }
        .empty-state { padding:40px; text-align:center; color:var(--text-3); }

        .btn-primary {
            display:inline-flex;
            align-items:center;
            gap:6px;
            background:var(--accent);
            color:#fff;
            padding:6px 12px;
            border-radius:var(--r);
            text-decoration:none;
            font-size:12px;
            font-weight:500;
        }
        .btn-outline {
            border:1px solid var(--border);
            background:transparent;
            color:var(--text-2);
            padding:6px 12px;
            border-radius:var(--r);
            text-decoration:none;
            font-size:12px;
        }
    </style>

    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    @endphp

    <!-- Hero -->
    <div class="hero">
        <p class="hero-greeting">{{ $greeting }}</p>
        <h2 class="hero-name">{{ auth()->user()->name }}</h2>
        <p class="hero-sub">Your dormitory overview at a glance</p>
        <span class="hero-role"><span class="hero-role-dot"></span> {{ auth()->user()->role }}</span>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Current Room</div><div class="stat-val">{{ $activeAllocation ? $activeAllocation->room->room_number : 'None' }}</div></div>
                <div class="stat-icon si-blue"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg></div>
            </div>
            <div class="stat-footer">{{ $activeAllocation ? 'Active allocation' : 'No active room' }}</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Total Requests</div><div class="stat-val">{{ $totalMaintenance ?? 0 }}</div></div>
                <div class="stat-icon si-amber"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
            </div>
            <div class="stat-footer">All maintenance requests</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Pending</div><div class="stat-val">{{ $pendingMaintenance ?? 0 }}</div></div>
                <div class="stat-icon si-amber"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
            </div>
            <div class="stat-footer">Awaiting action</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Resolved</div><div class="stat-val">{{ $resolvedMaintenance ?? 0 }}</div></div>
                <div class="stat-icon si-green"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            </div>
            <div class="stat-footer">Completed issues</div>
        </div>
    </div>

    <!-- Room Details (if allocated) -->
    @if($activeAllocation)
        <div class="room-detail-card">
            <div class="room-detail-header">
                <h3>Your Current Room</h3>
            </div>
            <div class="room-detail-body">
                @if($activeAllocation->room->image)
                    <img src="{{ asset('storage/' . $activeAllocation->room->image) }}" class="room-image" alt="Room image">
                @else
                    <div class="room-image" style="background:var(--surface-2); display:flex; align-items:center; justify-content:center;">No image</div>
                @endif
                <div class="room-info-grid">
                    <div class="room-info-item"><div class="room-info-label">Room Number</div><div class="room-info-value">{{ $activeAllocation->room->room_number }}</div></div>
                    <div class="room-info-item"><div class="room-info-label">Type</div><div class="room-info-value">{{ ucfirst($activeAllocation->room->type) }}</div></div>
                    <div class="room-info-item"><div class="room-info-label">Capacity</div><div class="room-info-value">{{ $activeAllocation->room->capacity }} person(s)</div></div>
                    <div class="room-info-item"><div class="room-info-label">Monthly Rate</div><div class="room-info-value">₱{{ number_format($activeAllocation->room->price_per_month, 2) }}</div></div>
                    <div class="room-info-item"><div class="room-info-label">Move-in Date</div><div class="room-info-value">{{ \Carbon\Carbon::parse($activeAllocation->start_date)->format('M d, Y') }}</div></div>
                    <div class="room-info-item"><div class="room-info-label">Status</div><div class="room-info-value"><span class="badge occupied">Occupied</span></div></div>
                </div>
                <div style="flex-basis:100%; margin-top:12px;">
                    <a href="{{ route('rooms.show', $activeAllocation->room) }}" class="btn-primary">View full details →</a>
                </div>
            </div>
        </div>
    @elseif($pendingApplication)
        <div class="room-detail-card">
            <div class="room-detail-header">
                <h3>Pending Application</h3>
            </div>
            <div class="room-detail-body">
                <div class="room-info-grid">
                    <div class="room-info-item"><div class="room-info-label">Requested Room</div><div class="room-info-value">Room {{ $pendingApplication->room->room_number }}</div></div>
                    <div class="room-info-item"><div class="room-info-label">Room Type</div><div class="room-info-value">{{ ucfirst($pendingApplication->room->type) }}</div></div>
                    <div class="room-info-item"><div class="room-info-label">Preferred Move-in</div><div class="room-info-value">{{ \Carbon\Carbon::parse($pendingApplication->preferred_move_in)->format('M d, Y') }}</div></div>
                    <div class="room-info-item"><div class="room-info-label">Status</div><div class="room-info-value"><span class="badge badge-pending">Pending approval</span></div></div>
                </div>
                <div style="margin-top:16px;">
                    <a href="{{ route('applications.my') }}" class="btn-primary">View my applications →</a>
                </div>
            </div>
        </div>
    @else
        <div class="room-detail-card">
            <div class="room-detail-header">
                <h3>No Active Allocation</h3>
            </div>
            <div class="room-detail-body" style="text-align:center;">
                <p>You are not currently assigned to a room. Request one now.</p>
                <a href="{{ route('applications.create') }}" class="btn-primary">Request a room →</a>
            </div>
        </div>
    @endif

    <!-- Maintenance Requests Section -->
    <div class="card" style="margin-bottom:24px;">
        <div class="card-hd">
            <h3 class="card-hd-title">Recent Maintenance Requests</h3>
            <a href="{{ route('maintenance-requests.create') }}" class="card-hd-link">+ New request</a>
        </div>
        @if($recentRequests->count() > 0)
            <table class="maintenance-table">
                <thead>
                    <tr><th>Title</th><th>Room</th><th>Priority</th><th>Status</th><th>Submitted</th></tr>
                </thead>
                <tbody>
                    @foreach($recentRequests as $req)
                    <tr>
                        <td>{{ $req->title }}</td>
                        <td>Room {{ $req->room->room_number }}</td>
                        <td><span class="badge priority-{{ $req->priority }}">{{ ucfirst($req->priority) }}</span></td>
                        <td><span class="badge badge-{{ str_replace('_', '-', $req->status) }}">{{ ucfirst(str_replace('_', ' ', $req->status)) }}</span></td>
                        <td>{{ $req->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:12px 20px; text-align:center; border-top:1px solid var(--border);">
                <a href="{{ route('maintenance-requests.index') }}" class="card-hd-link">View all requests →</a>
            </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;color:var(--text-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p>No maintenance requests yet.</p>
                <a href="{{ route('maintenance-requests.create') }}" class="btn-primary" style="margin-top:12px;">Report an issue →</a>
            </div>
        @endif
    </div>

    <!-- Allocation History (past rooms) -->
    @if(isset($pastAllocations) && $pastAllocations->count() > 0)
    <div class="card">
        <div class="card-hd">
            <h3 class="card-hd-title">Room History</h3>
        </div>
        <table class="history-table">
            <thead>
                <tr><th>Room</th><th>Move-in</th><th>Move-out</th><th>Duration</th></tr>
            </thead>
            <tbody>
                @foreach($pastAllocations as $alloc)
                <tr>
                    <td>Room {{ $alloc->room->room_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($alloc->start_date)->format('M d, Y') }}</td>
                    <td>{{ $alloc->end_date ? \Carbon\Carbon::parse($alloc->end_date)->format('M d, Y') : 'Present' }}</td>
                    <td>{{ \Carbon\Carbon::parse($alloc->start_date)->diffForHumans($alloc->end_date ?? now(), true) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Quick Actions -->
    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
        <a href="{{ route('profile.edit') }}" class="btn-outline">Edit Profile</a>
        <a href="{{ route('rooms.index') }}" class="btn-outline">Browse Rooms</a>
    </div>

</x-app-layout>