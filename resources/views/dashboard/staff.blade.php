<x-app-layout>
    <x-slot name="header">
        <h2 class="page-header-title">Staff Dashboard</h2>
    </x-slot>

    <style>
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 500;
        }
        .badge-pending { background: var(--amber-bg); color: var(--amber); }
        .badge-in_progress { background: var(--accent-bg); color: var(--accent); }
        .badge-resolved { background: var(--green-bg); color: var(--green); }
        .priority-low { background: var(--green-bg); color: var(--green); }
        .priority-medium { background: var(--amber-bg); color: var(--amber); }
        .priority-high { background: var(--red-bg); color: var(--red); }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            overflow: hidden;
        }
        .card-hd {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
        }
        .card-hd-title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }
        .card-hd-link {
            font-size: 12.5px;
            color: var(--accent-tx);
            text-decoration: none;
        }
        .card-hd-link:hover { text-decoration: underline; }

        .hero {
            background: #0F0E09;
            border-radius: var(--r3);
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.07);
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -60px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(26,86,219,.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-greeting { font-size: 11px; letter-spacing: .1em; text-transform: uppercase; color: #60A5FA; font-weight: 600; margin-bottom: 6px; }
        .hero-name { font-size: 22px; font-weight: 700; color: #F0EEE8; letter-spacing: -.4px; margin: 0 0 6px; }
        .hero-sub { font-size: 13px; color: #5B5950; margin: 0 0 16px; font-weight: 300; }
        .hero-role {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 99px;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.09);
            font-size: 12px;
            color: #9A9890;
            text-transform: capitalize;
        }
        .hero-role-dot { width: 6px; height: 6px; border-radius: 50%; background: #60A5FA; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }
        @media (max-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }

        .stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 18px;
            transition: box-shadow 0.2s;
        }
        .stat:hover { box-shadow: var(--shadow); border-color: var(--border-md); }
        .stat-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .stat-label { font-size: 11.5px; color: var(--text-3); font-weight: 500; }
        .stat-val { font-size: 30px; font-weight: 700; letter-spacing: -0.04em; font-family: var(--mono); }
        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .si-blue { background: var(--accent-bg); color: var(--accent); }
        .si-amber { background: var(--amber-bg); color: var(--amber); }
        .si-green { background: var(--green-bg); color: var(--green); }
        .stat-footer { font-size: 11.5px; color: var(--text-3); margin-top: 8px; }

        .requests-table {
            width: 100%;
            border-collapse: collapse;
        }
        .requests-table th,
        .requests-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .requests-table th {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-update-form {
            display: inline-flex;
            gap: 6px;
            align-items: center;
        }
        .status-update-form select {
            padding: 4px 6px;
            border-radius: var(--r);
            border: 1px solid var(--border-md);
            background: var(--surface);
            font-size: 12px;
            color: var(--text);
        }
        .status-update-form button {
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: 4px 8px;
            border-radius: var(--r);
            font-size: 11px;
            cursor: pointer;
        }
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-3);
        }
    </style>

    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
        $pendingCount = $assignedRequests->where('status', 'pending')->count();
        $inProgressCount = $assignedRequests->where('status', 'in_progress')->count();
        $unassignedCount = $assignedRequests->whereNull('assigned_to')->count();
        $myAssignedCount = $assignedRequests->where('assigned_to', auth()->id())->count();
    @endphp

    <!-- Hero -->
    <div class="hero">
        <p class="hero-greeting">{{ $greeting }}</p>
        <h2 class="hero-name">{{ auth()->user()->name }}</h2>
        <p class="hero-sub">Manage maintenance requests – view pending, unassigned, and your assigned tasks.</p>
        <span class="hero-role"><span class="hero-role-dot"></span> {{ auth()->user()->role }}</span>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Pending & Unassigned</div><div class="stat-val">{{ $pendingCount + $unassignedCount }}</div></div>
                <div class="stat-icon si-amber">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Awaiting action or assignment</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Assigned to You</div><div class="stat-val">{{ $myAssignedCount }}</div></div>
                <div class="stat-icon si-blue">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Your current workload</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Resolved</div><div class="stat-val">{{ $resolvedCount }}</div></div>
                <div class="stat-icon si-green">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Completed tasks</div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="card">
        <div class="card-hd">
            <h3 class="card-hd-title">All Pending & Unassigned Requests</h3>
            <a href="{{ route('maintenance-requests.index') }}" class="card-hd-link">Manage all →</a>
        </div>
        @if($assignedRequests->count() > 0)
            <div class="table-responsive">
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedRequests as $req)
                        <tr>
                            <td>Room {{ $req->room->room_number }}</td>
                            <td>{{ $req->title }}</td>
                            <td><span class="badge priority-{{ $req->priority }}">{{ ucfirst($req->priority) }}</span></td>
                            <td><span class="badge badge-{{ str_replace('_', '-', $req->status) }}">{{ ucfirst(str_replace('_', ' ', $req->status)) }}</span></td>
                            <td>{{ $req->created_at->diffForHumans() }}</td>
                            <td>
                                <form method="POST" action="{{ route('maintenance-requests.update-status', $req) }}" class="status-update-form">
                                    @csrf @method('PATCH')
                                    <select name="status">
                                        <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $req->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ $req->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;color:var(--text-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p>No pending or unassigned maintenance requests.</p>
                <a href="{{ route('maintenance-requests.index') }}" class="btn-primary" style="margin-top:12px;">View all requests</a>
            </div>
        @endif
    </div>
</x-app-layout>     