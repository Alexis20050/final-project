<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="page-header-title">Room Applications</h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">Manage student room requests</span>
        </div>
    </x-slot>

    {{-- 🔴 Error alert --}}
    @if($errors->any())
        <div style="background:var(--red-bg); color:var(--red); padding:12px 16px; border-radius:var(--r); margin-bottom:16px; font-size:14px;">
            @foreach($errors->all() as $error)
                <p style="margin:0;">⚠️ {{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- ✅ Success alert --}}
    @if(session('success'))
        <div style="background:var(--green-bg); color:var(--green); padding:12px 16px; border-radius:var(--r); margin-bottom:16px; font-size:14px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <style>
        /* Filter chips */
        .filters {
            display: flex; gap: 6px; margin-bottom: 16px; flex-wrap: wrap;
        }
        .chip {
            padding: 5px 13px; border-radius: 99px;
            font-size: 12.5px; font-weight: 500;
            border: 1px solid var(--border-md);
            background: var(--surface); color: var(--text-2);
            text-decoration: none;
            transition: background .12s, color .12s, border-color .12s;
        }
        .chip:hover { background: var(--surface-2); color: var(--text); }
        .chip.on {
            background: var(--accent); color: #fff;
            border-color: var(--accent);
            box-shadow: 0 1px 4px rgba(26,86,219,.25);
        }

        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 9px; border-radius: 99px;
            font-size: 11.5px; font-weight: 500;
        }
        .badge-pending { background: var(--amber-bg); color: var(--amber); }
        .badge-approved { background: var(--green-bg); color: var(--green); }
        .badge-rejected { background: var(--red-bg); color: var(--red); }
        .badge-cancelled { background: var(--surface-2); color: var(--text-3); }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,.03);
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 {
            font-size: 14px; font-weight: 600;
            color: var(--text); margin: 0;
        }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 14px 16px; text-align: left;
            border-bottom: 1px solid var(--border); vertical-align: middle;
        }
        th {
            font-size: 12px; font-weight: 600; color: var(--text-3);
            text-transform: uppercase; letter-spacing: 0.06em;
            background: var(--surface-2); border-bottom: 2px solid var(--border);
        }
        td { font-size: 13.5px; color: var(--text); }
        tbody tr:nth-child(even) { background: var(--surface-2); }
        tbody tr:hover { background: var(--surface-3); }

        .action-buttons { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .btn-sm {
            padding: 5px 12px; border-radius: var(--r);
            font-size: 12px; font-weight: 500;
            text-decoration: none; transition: all 0.15s;
            cursor: pointer; border: 1px solid transparent;
        }
        .btn-approve {
            background: var(--green-bg); color: var(--green);
            border-color: var(--green);
        }
        .btn-approve:hover { background: var(--green); color: #fff; }
        .btn-reject {
            background: var(--red-bg); color: var(--red);
            border-color: var(--red);
        }
        .btn-reject:hover { background: var(--red); color: #fff; }
        .reject-form { display: inline-flex; gap: 6px; align-items: center; }
        .reject-form input {
            padding: 5px 10px; border-radius: var(--r);
            border: 1px solid var(--border-md);
            background: var(--surface); font-size: 12px; width: 140px;
        }
        .empty-state {
            padding: 60px 20px; text-align: center; color: var(--text-3);
        }
        .pagination-wrapper {
            padding: 12px 20px; border-top: 1px solid var(--border);
            background: var(--surface-2);
        }
    </style>

    {{-- Filter chips (only visible when status is filtered or always) --}}
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
                            <th>Preferred Move-in</th>
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
                            <td>Room {{ $app->room->room_number }}<br><span style="font-size:12px; color:var(--text-3);">{{ ucfirst($app->room->type) }}</span></td>
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
                                              onsubmit="return confirm('Approve this application and allocate the room?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-sm btn-approve">Approve</button>
                                        </form>
                                        <form action="{{ route('applications.reject', $app) }}" method="POST" class="reject-form">
                                            @csrf @method('PATCH')
                                            <input type="text" name="admin_notes" placeholder="Reason (optional)">
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
                <div class="empty-state">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;color:var(--text-3); opacity:.5;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/>
                    </svg>
                    <p>No room applications found.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>