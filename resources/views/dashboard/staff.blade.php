<x-app-layout>
    <x-slot name="header">
        <h2 class="page-header-title">Staff Dashboard</h2>
    </x-slot>

    <style>
        /* Additional dashboard-specific styles (uses theme variables) */
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
            flex-wrap: wrap;
            gap: 12px;
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
            transition: all 0.2s;
        }
        .stat:hover { box-shadow: var(--shadow); border-color: var(--border-md); transform: translateY(-1px); }
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
            background: var(--surface-2);
        }
        .requests-table tr {
            transition: background 0.15s;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }
        .btn-icon {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: none;
        }
        .btn-update {
            background: var(--surface-2);
            color: var(--text-2);
            border: 1px solid var(--border);
        }
        .btn-update:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
            transform: translateY(-1px);
        }
        .update-select {
            padding: 5px 8px;
            border-radius: 20px;
            border: 1px solid var(--border-md);
            background: var(--surface);
            font-size: 12px;
            color: var(--text);
            outline: none;
        }
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-3);
        }
        .empty-state svg {
            width: 60px;
            height: 60px;
            margin-bottom: 16px;
            opacity: 0.5;
        }
        @media (max-width: 768px) {
            .requests-table, .requests-table thead, .requests-table tbody, .requests-table th, .requests-table td, .requests-table tr {
                display: block;
            }
            .requests-table thead {
                display: none;
            }
            .requests-table tr {
                margin-bottom: 16px;
                border: 1px solid var(--border);
                border-radius: var(--r);
                padding: 12px;
            }
            .requests-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
            }
            .requests-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--text-3);
                width: 35%;
            }
            .action-buttons {
                justify-content: flex-end;
                width: 100%;
            }
        }
    </style>

    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');

        // Ensure $assignedRequests is a Collection (passed from controller)
        // It should contain all maintenance requests relevant to staff (assigned to current user OR unassigned)
        $requests = $assignedRequests ?? collect();

        // Correct stats
        $pendingCount = $requests->where('status', 'pending')->count();
        $unassignedCount = $requests->whereNull('assigned_to')->where('status', '!=', 'resolved')->count();
        $myAssignedCount = $requests->where('assigned_to', auth()->id())->count();
        $resolvedCount = $requests->where('status', 'resolved')->count();

        // Unique count for "Pending & Unassigned" without double‑counting
        $pendingOrUnassignedIds = $requests->filter(fn($r) => $r->status === 'pending' || is_null($r->assigned_to))->unique('id')->count();

        // Take only the 10 most recent for the dashboard table
        $recentRequests = $requests->sortByDesc('created_at')->take(10);
    @endphp

    <!-- Hero Section -->
    <div class="hero">
        <p class="hero-greeting">{{ $greeting }}</p>
        <h2 class="hero-name">{{ auth()->user()->name }}</h2>
        <p class="hero-sub">Manage maintenance requests – update status and track progress.</p>
        <span class="hero-role"><span class="hero-role-dot"></span> {{ auth()->user()->role }}</span>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Pending / Unassigned</div>
                    <div class="stat-val">{{ $pendingOrUnassignedIds }}</div>
                </div>
                <div class="stat-icon si-amber">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Awaiting action</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Assigned to You</div>
                    <div class="stat-val">{{ $myAssignedCount }}</div>
                </div>
                <div class="stat-icon si-blue">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Your workload</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Resolved</div>
                    <div class="stat-val">{{ $resolvedCount }}</div>
                </div>
                <div class="stat-icon si-green">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Completed tasks</div>
        </div>
    </div>

    <!-- Recent Requests Card -->
    <div class="card">
        <div class="card-hd">
            <h3 class="card-hd-title">Recent Maintenance Requests</h3>
            <a href="{{ route('maintenance-requests.index') }}" class="card-hd-link">View all →</a>
        </div>

        <div class="table-responsive">
            @if($recentRequests->isNotEmpty())
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentRequests as $req)
                            <tr>
                                <td data-label="Room">Room {{ $req->room->room_number ?? 'N/A' }}</td>
                                <td data-label="Title">{{ $req->title }}</td>
                                <td data-label="Priority">
                                    <span class="badge priority-{{ $req->priority }}">{{ ucfirst($req->priority) }}</span>
                                </td>
                                <td data-label="Status">
                                    <span class="badge badge-{{ str_replace('_', '-', $req->status) }}">{{ ucfirst(str_replace('_', ' ', $req->status)) }}</span>
                                </td>
                                <td data-label="Submitted">{{ $req->created_at->diffForHumans() }}</td>
                                <td data-label="Update Status" class="action-buttons">
                                    <form method="POST" action="{{ route('maintenance-requests.update-status', $req) }}" class="inline" onsubmit="return confirm('Update status to the selected value?')">
                                        @csrf
                                        @method('PATCH')
                                        <div style="display: inline-flex; gap: 6px; align-items: center;">
                                            <select name="status" class="update-select">
                                                <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in_progress" {{ $req->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="resolved" {{ $req->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            </select>
                                            <button type="submit" class="btn-icon btn-update">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p>No maintenance requests found.</p>
                    <a href="{{ route('maintenance-requests.create') }}" class="btn-primary" style="margin-top:12px; display:inline-block;">+ Create new request</a>
                </div>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif
</x-app-layout>