<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="page-header-title">Room Applications</h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">Manage requests</span>
        </div>
    </x-slot>

    {{-- Alerts --}}
    @if($errors->any())
        <div style="background:var(--red-bg); color:var(--red); padding:12px 16px; border-radius:var(--r); margin-bottom:12px; font-size:14px;">
            @foreach($errors->all() as $error)
                <p style="margin:0;">⚠️ {{ $error }}</p>
            @endforeach
        </div>
    @endif
    @if(session('success'))
        <div style="background:var(--green-bg); color:var(--green); padding:12px 16px; border-radius:var(--r); margin-bottom:12px; font-size:14px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <style>
        .filters {
            display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 16px;
        }
        .chip {
            padding: 5px 13px; border-radius: 99px;
            font-size: 12.5px; font-weight: 500;
            border: 1px solid var(--border-md);
            background: var(--surface); color: var(--text-2);
            text-decoration: none;
            transition: all .12s;
        }
        .chip:hover { background: var(--surface-2); color: var(--text); }
        .chip.on {
            background: var(--accent); color: #fff;
            border-color: var(--accent);
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            overflow: hidden;
        }
        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 { font-size: 14px; font-weight: 600; color: var(--text); margin: 0; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 10px 14px; text-align: left;
            border-bottom: 1px solid var(--border); vertical-align: middle;
        }
        th {
            font-size: 12px; font-weight: 600; color: var(--text-3);
            text-transform: uppercase; letter-spacing: 0.05em;
            background: var(--surface-2);
        }
        td { font-size: 13px; color: var(--text); }
        tbody tr:nth-child(even) { background: var(--surface-2); }
        tbody tr:hover { background: var(--surface-3); }

        .badge {
            display: inline-flex; align-items: center;
            padding: 2px 8px; border-radius: 99px;
            font-size: 11px; font-weight: 500;
        }
        .badge-pending { background: var(--amber-bg); color: var(--amber); }
        .badge-approved { background: var(--green-bg); color: var(--green); }
        .badge-rejected { background: var(--red-bg); color: var(--red); }
        .badge-cancelled { background: var(--surface-2); color: var(--text-3); }

        .action-buttons { display: flex; gap: 8px; align-items: center; }
        .btn-sm {
            padding: 4px 10px; border-radius: var(--r);
            font-size: 12px; font-weight: 500; border: 1px solid transparent;
            cursor: pointer; text-decoration: none; transition: all .15s;
        }
        .btn-approve { background: var(--green-bg); color: var(--green); border-color: var(--green); }
        .btn-approve:hover { background: var(--green); color: #fff; }
        .btn-reject { background: var(--red-bg); color: var(--red); border-color: var(--red); }
        .btn-reject:hover { background: var(--red); color: #fff; }
        .reject-form { display: inline-flex; gap: 4px; align-items: center; }
        .reject-form input {
            padding: 4px 8px; border-radius: var(--r); border: 1px solid var(--border-md);
            background: var(--surface); font-size: 11px; width: 110px;
        }

        .pagination-wrapper {
            padding: 12px 20px; border-top: 1px solid var(--border);
            background: var(--surface-2);
        }
    </style>

    <!-- Filter chips (no search) -->
    <div class="filters">
        <a href="{{ route('applications.index') }}" class="chip {{ !request('status') ? 'on' : '' }}">All</a>
        <a href="{{ route('applications.index', ['status' => 'pending']) }}" class="chip {{ request('status') === 'pending' ? 'on' : '' }}">Pending</a>
        <a href="{{ route('applications.index', ['status' => 'approved']) }}" class="chip {{ request('status') === 'approved' ? 'on' : '' }}">Approved</a>
        <a href="{{ route('applications.index', ['status' => 'rejected']) }}" class="chip {{ request('status') === 'rejected' ? 'on' : '' }}">Rejected</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Student Room Requests</h3>
            <span class="text-xs text-gray-500">{{ $applications->total() }} total</span>
        </div>
        <div class="table-responsive">
            @if($applications->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Room</th>
                            <th>Move‑in</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                            <tr>
                                <td>
                                    <div style="font-weight:500;">{{ $app->user->name }}</div>
                                    <div style="font-size:12px; color:var(--text-3);">{{ $app->user->email }}</div>
                                </td>
                                <td>Room {{ $app->room->room_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($app->preferred_move_in)->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $app->status }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td style="font-size:12px; color:var(--text-2);">{{ $app->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($app->status === 'pending')
                                        <div class="action-buttons">
                                            <form action="{{ route('applications.approve', $app) }}" method="POST"
                                                  onsubmit="return confirm('Approve and allocate this room?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-sm btn-approve">Approve</button>
                                            </form>
                                            <form action="{{ route('applications.reject', $app) }}" method="POST" class="reject-form">
                                                @csrf @method('PATCH')
                                                <input type="text" name="admin_notes" placeholder="Reason…">
                                                <button type="submit" class="btn-sm btn-reject">Reject</button>
                                            </form>
                                        </div>
                                    @else
                                        <span style="font-size:12px; color: var(--text-3);">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper">
                    {{ $applications->links('components.pagination') }}
                </div>
            @else
                <div style="padding:60px 20px; text-align:center; color:var(--text-3);">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px; opacity:.4;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/>
                    </svg>
                    <p>No applications found.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>