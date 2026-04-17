<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <h2 class="page-header-title">Maintenance Requests</h2>
            @if(auth()->user()->isResident())
                <a href="{{ route('maintenance-requests.create') }}" class="btn-primary" style="padding:6px 12px; font-size:13px;">+ New Request</a>
            @endif
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
        .badge-in_progress { background: var(--accent-bg); color: var(--accent); }
        .badge-resolved { background: var(--green-bg); color: var(--green); }
        .badge-cancelled { background: var(--surface-2); color: var(--text-3); }

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
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-3);
        }
        .btn-sm {
            padding: 4px 10px;
            border-radius: var(--r);
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-primary-sm {
            background: var(--accent);
            color: #fff;
            border: none;
        }
        .btn-primary-sm:hover {
            opacity: 0.85;
        }
        .update-form {
            display: inline-flex;
            gap: 6px;
            align-items: center;
        }
        .update-form select {
            padding: 4px 6px;
            border-radius: var(--r);
            border: 1px solid var(--border-md);
            background: var(--surface);
            font-size: 12px;
            color: var(--text);
        }
        .update-form button {
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: 4px 8px;
            border-radius: var(--r);
            font-size: 11px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .update-form button:hover {
            background: var(--surface);
        }
        .inline-form {
            display: inline;
        }
    </style>

    <div class="card">
        <div class="card-hd">
            <h3 class="card-hd-title">All Requests</h3>
        </div>
        <div class="table-responsive">
            @if($requests->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr>
                            <td>Room {{ $req->room->room_number }}</td>
                            <td>{{ $req->title }}</td>
                            <td>
                                <span class="badge priority-{{ $req->priority }}">
                                    {{ ucfirst($req->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $req->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                </span>
                            </td>
                            <td>
                                @if($req->assignedStaff)
                                    {{ $req->assignedStaff->name }}
                                @else
                                    <span class="text-muted" style="color:var(--text-3);">Unassigned</span>
                                @endif
                            </td>
                            <td>{{ $req->created_at->diffForHumans() }}</td>
                            <td>
                                @if(auth()->user()->isStaff())
                                    <form method="POST" action="{{ route('maintenance-requests.update-status', $req) }}" class="update-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status">
                                            <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $req->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ $req->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                        <button type="submit">Update</button>
                                    </form>
                                @endif
                                @if(auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('maintenance-requests.assign', $req) }}" class="update-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="assigned_to">
                                            <option value="">Assign to</option>
                                            @foreach($staffList ?? [] as $staff)
                                                <option value="{{ $staff->id }}" {{ $req->assigned_to == $staff->id ? 'selected' : '' }}>{{ $staff->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit">Assign</button>
                                    </form>
                                @endif
                                @if(auth()->user()->isResident() && $req->user_id == auth()->id() && $req->status == 'pending')
                                    <form method="POST" action="{{ route('maintenance-requests.destroy', $req) }}" class="inline-form" onsubmit="return confirm('Cancel this request?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm" style="background:var(--red-bg);color:var(--red);">Cancel</button>
                                    </form>
                                @endif
                             </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding: 12px 16px;">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="empty-state">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;color:var(--text-3);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p>No maintenance requests found.</p>
                    @if(auth()->user()->isResident())
                        <a href="{{ route('maintenance-requests.create') }}" class="btn-primary-sm" style="margin-top:12px;">Report an issue →</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>