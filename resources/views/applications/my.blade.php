<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:10px;">
            <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:7px;border:1px solid var(--border-md);background:var(--surface);color:var(--text-2);text-decoration:none;transition:background .12s;" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='var(--surface)'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">My Room Applications</h2>
        </div>
    </x-slot>

    <style>
        .badge {
            display:inline-flex;
            align-items:center;
            padding:3px 9px;
            border-radius:99px;
            font-size:11.5px;
            font-weight:500;
        }
        .badge-pending { background:var(--amber-bg); color:var(--amber); }
        .badge-approved { background:var(--green-bg); color:var(--green); }
        .badge-rejected { background:var(--red-bg); color:var(--red); }
        .badge-cancelled { background:var(--surface-2); color:var(--text-3); }
        .card {
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:var(--r2);
            overflow:hidden;
        }
        .card-hd {
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:14px 20px;
            border-bottom:1px solid var(--border);
        }
        .card-hd-title {
            font-size:13.5px;
            font-weight:600;
            color:var(--text);
            margin:0;
        }
        .table-responsive {
            overflow-x:auto;
        }
        table {
            width:100%;
            border-collapse:collapse;
        }
        th, td {
            padding:12px 16px;
            text-align:left;
            border-bottom:1px solid var(--border);
        }
        th {
            font-size:12px;
            font-weight:600;
            color:var(--text-3);
            text-transform:uppercase;
            letter-spacing:.05em;
        }
        td {
            font-size:13px;
            color:var(--text);
        }
        .empty-state {
            padding:40px;
            text-align:center;
            color:var(--text-3);
        }
        .btn-sm {
            padding:4px 12px;
            border-radius:var(--r);
            font-size:12px;
            font-weight:500;
            text-decoration:none;
            transition:background .12s;
        }
        .btn-cancel {
            background:var(--red-bg);
            color:var(--red);
            border:1px solid var(--border);
        }
        .btn-cancel:hover {
            background:var(--red);
            color:#fff;
        }
    </style>

    <div class="card">
        <div class="card-hd">
            <h3 class="card-hd-title">Your Requests</h3>
        </div>
        <div class="table-responsive">
            @if($applications->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Preferred Move-in</th>
                            <th>Status</th>
                            <th>Admin Notes</th>
                            <th>Submitted</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                        <tr>
                            <td>Room {{ $app->room->room_number }} ({{ ucfirst($app->room->type) }})</td>
                            <td>{{ \Carbon\Carbon::parse($app->preferred_move_in)->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $app->status }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td>{{ $app->admin_notes ?? '—' }}</td>
                            <td>{{ $app->created_at->diffForHumans() }}</td>
                            <td>
                                @if($app->status === 'pending')
                                    <form method="POST" action="{{ route('applications.destroy', $app) }}" onsubmit="return confirm('Cancel this application?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-cancel">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding:12px 16px;">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="empty-state">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;color:var(--text-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                    <p>You have not submitted any room requests yet.</p>
                    <a href="{{ route('applications.create') }}" class="btn-primary" style="margin-top:12px;">Request a room →</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>