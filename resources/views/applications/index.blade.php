<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="page-header-title">Room Applications</h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">Manage student room requests</span>
        </div>
    </x-slot>

    <style>
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 500;
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
        }
        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }
        .card-header h3 {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        th {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td {
            font-size: 13px;
            color: var(--text);
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-sm {
            padding: 4px 10px;
            border-radius: var(--r);
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s;
            cursor: pointer;
            border: none;
        }
        .btn-approve {
            background: var(--green-bg);
            color: var(--green);
            border: 1px solid var(--border);
        }
        .btn-approve:hover {
            background: var(--green);
            color: #fff;
        }
        .btn-reject {
            background: var(--red-bg);
            color: var(--red);
            border: 1px solid var(--border);
        }
        .btn-reject:hover {
            background: var(--red);
            color: #fff;
        }
        .reject-form {
            display: inline-flex;
            gap: 6px;
            align-items: center;
        }
        .reject-form input {
            padding: 4px 8px;
            border-radius: var(--r);
            border: 1px solid var(--border-md);
            background: var(--surface);
            font-size: 12px;
            width: 140px;
        }
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-3);
        }
        .pagination {
            padding: 12px 20px;
            border-top: 1px solid var(--border);
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h3>Student Room Requests</h3>
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
                                <div class="font-medium">{{ $app->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $app->user->email }}</div>
                            </td>
                            <td>Room {{ $app->room->room_number }}<br><span class="text-xs text-gray-500">{{ ucfirst($app->room->type) }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($app->preferred_move_in)->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $app->status }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td>{{ $app->created_at->diffForHumans() }}</td>
                            <td>
                                @if($app->status === 'pending')
                                    <div class="action-buttons">
                                        <form action="{{ route('applications.approve', $app) }}" method="POST" class="inline">
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
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="empty-state">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;color:var(--text-3);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/>
                    </svg>
                    <p>No room applications found.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>