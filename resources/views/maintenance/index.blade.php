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
        .badge-pending    { background: var(--amber-bg); color: var(--amber); }
        .badge-in_progress{ background: var(--accent-bg); color: var(--accent); }
        .badge-resolved   { background: var(--green-bg); color: var(--green); }
        .badge-cancelled  { background: var(--surface-2); color: var(--text-3); }
        .priority-low     { background: var(--green-bg); color: var(--green); }
        .priority-medium  { background: var(--amber-bg); color: var(--amber); }
        .priority-high    { background: var(--red-bg); color: var(--red); }

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
        .card-hd-title { font-size: 13.5px; font-weight: 600; color: var(--text); margin: 0; }

        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        th {
            font-size: 12px; font-weight: 600; color: var(--text-3);
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        td { font-size: 13px; color: var(--text); }

        .empty-state { padding: 60px 20px; text-align: center; color: var(--text-3); }

        .btn-sm {
            padding: 4px 10px; border-radius: var(--r);
            font-size: 12px; font-weight: 500;
            text-decoration: none; transition: all 0.15s;
        }
        .update-form { display: inline-flex; gap: 6px; align-items: center; }
        .update-form select {
            padding: 4px 6px; border-radius: var(--r);
            border: 1px solid var(--border-md);
            background: var(--surface); font-size: 12px; color: var(--text);
        }
        .update-form button {
            background: var(--surface-2); border: 1px solid var(--border);
            padding: 4px 8px; border-radius: var(--r);
            font-size: 11px; cursor: pointer; transition: background 0.15s;
            color: var(--text);
        }
        .update-form button:hover { background: var(--surface); }
        .inline-form { display: inline; }

        /* ── Description cell ── */
        .desc-cell { max-width: 200px; }
        .desc-short {
            font-size: 13px;
            color: var(--text-2);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
            display: block;
        }
        .desc-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
            font-size: 11.5px;
            font-weight: 500;
            color: var(--accent-tx);
            background: var(--accent-bg);
            border: none;
            border-radius: 99px;
            padding: 2px 9px;
            cursor: pointer;
            transition: opacity .15s;
        }
        .desc-btn:hover { opacity: .8; }
        .desc-btn svg { width: 11px; height: 11px; }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 500;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 24px 64px rgba(0,0,0,.18);
            overflow: hidden;
            animation: modalIn .2s cubic-bezier(.4,0,.2,1) both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(12px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-hd {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border);
            gap: 12px;
        }
        .modal-title-wrap { display: flex; flex-direction: column; gap: 6px; }
        .modal-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--text-3);
        }
        .modal-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin: 0;
            line-height: 1.3;
        }
        .modal-close {
            width: 30px; height: 30px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface-2);
            color: var(--text-3);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all .15s;
        }
        .modal-close:hover { background: var(--surface); color: var(--text); }
        .modal-close svg { width: 14px; height: 14px; }
        .modal-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }
        .modal-meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--text-2);
        }
        .modal-meta-item svg { width: 12px; height: 12px; color: var(--text-3); }
        .modal-body { padding: 20px; }
        .modal-desc-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--text-3);
            margin-bottom: 10px;
        }
        .modal-desc-text {
            font-size: 14px;
            color: var(--text);
            line-height: 1.7;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 16px;
            margin: 0;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .modal-ft {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
        }
        .modal-ft button {
            padding: 7px 18px;
            border-radius: var(--r);
            background: var(--surface-2);
            border: 1px solid var(--border);
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
            transition: background .15s;
        }
        .modal-ft button:hover { background: var(--surface-3, var(--surface)); }
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
                            <th>Reported By</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr>
                            <td>Room {{ $req->room->room_number }}</td>
                            <td>{{ $req->user->name ?? '—' }}</td>
                            <td>{{ $req->title }}</td>
                            <td class="desc-cell">
                                <span class="desc-short">{{ $req->description }}</span>
                                @if(strlen($req->description) > 40)
                                <button
                                    class="desc-btn"
                                    onclick="openDesc(
                                        {{ $req->id }},
                                        {{ json_encode($req->title) }},
                                        {{ json_encode($req->description) }},
                                        {{ json_encode('Room ' . $req->room->room_number) }},
                                        {{ json_encode(ucfirst($req->priority)) }},
                                        {{ json_encode(ucfirst(str_replace('_', ' ', $req->status))) }},
                                        {{ json_encode($req->created_at->format('M d, Y · g:i A')) }}
                                    )"
                                >
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Read more
                                </button>
                                @endif
                            </td>
                            <td>
                                <span class="badge priority-{{ $req->priority }}">{{ ucfirst($req->priority) }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $req->status }}">{{ ucfirst(str_replace('_', ' ', $req->status)) }}</span>
                            </td>
                            <td>{{ $req->created_at->diffForHumans() }}</td>
                            <td>
                                @if(auth()->user()->isStaff())
                                    <form method="POST" action="{{ route('maintenance-requests.update-status', $req) }}" class="update-form">
                                        @csrf @method('PATCH')
                                        <select name="status">
                                            <option value="pending"     {{ $req->status == 'pending'     ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $req->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved"    {{ $req->status == 'resolved'    ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                        <button type="submit">Update</button>
                                    </form>
                                @endif
                                @if(auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('maintenance-requests.assign', $req) }}" class="update-form">
                                        @csrf @method('PATCH')
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
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-sm" style="background:var(--red-bg);color:var(--red);">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding: 12px 16px;">
                    {{ $requests->links('components.pagination') }}
                </div>
            @else
                <div class="empty-state">
                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;color:var(--text-3);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p>No maintenance requests found.</p>
                    @if(auth()->user()->isResident())
                        <a href="{{ route('maintenance-requests.create') }}" style="display:inline-block;margin-top:12px;padding:6px 14px;background:var(--accent);color:#fff;border-radius:var(--r);font-size:13px;text-decoration:none;">Report an issue →</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Description Modal -->
    <div class="modal-overlay" id="descModal" onclick="closeOnOverlay(event)">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal-hd">
                <div class="modal-title-wrap">
                    <span class="modal-label">Request Details</span>
                    <h3 class="modal-title" id="modalTitle">—</h3>
                </div>
                <button class="modal-close" onclick="closeDesc()" aria-label="Close">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-meta" id="modalMeta">
                <!-- filled by JS -->
            </div>
            <div class="modal-body">
                <div class="modal-desc-label">Description</div>
                <p class="modal-desc-text" id="modalDesc">—</p>
            </div>
            <div class="modal-ft">
                <button onclick="closeDesc()">Close</button>
            </div>
        </div>
    </div>

    <script>
        function openDesc(id, title, desc, room, priority, status, submitted) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalDesc').textContent  = desc;

            const priorityColor = {
                'Low':    'var(--green)',
                'Medium': 'var(--amber)',
                'High':   'var(--red)',
            }[priority] || 'var(--text-3)';

            const statusColor = {
                'Pending':     'var(--amber)',
                'In Progress': 'var(--accent)',
                'Resolved':    'var(--green)',
                'Cancelled':   'var(--text-3)',
            }[status] || 'var(--text-3)';

            document.getElementById('modalMeta').innerHTML = `
                <span class="modal-meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                    ${room}
                </span>
                <span class="modal-meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span style="color:${priorityColor};font-weight:600;">${priority} priority</span>
                </span>
                <span class="modal-meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span style="color:${statusColor};font-weight:600;">${status}</span>
                </span>
                <span class="modal-meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    ${submitted}
                </span>
            `;

            const modal = document.getElementById('descModal');
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDesc() {
            document.getElementById('descModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function closeOnOverlay(e) {
            if (e.target === document.getElementById('descModal')) closeDesc();
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeDesc();
        });
    </script>
</x-app-layout>