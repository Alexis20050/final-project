<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="page-header-title">User Management</h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">
            </span>
        </div>
    </x-slot>

    <style>
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r3);
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,.03);
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }
        .card-header h3 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }
        .search-section {
            padding: 16px 20px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }
        .search-input-wrapper {
            flex: 3;
            min-width: 200px;
        }
        .search-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-md);
            border-radius: var(--r);
            background: var(--surface);
            color: var(--text);
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }
        .btn-search, .btn-clear {
            padding: 10px 18px;
            border-radius: var(--r);
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-search {
            background: var(--accent);
            color: #fff;
            border: none;
        }
        .btn-search:hover { background: var(--accent-dark); transform: translateY(-1px); }
        .btn-clear {
            background: var(--surface-2);
            color: var(--text-2);
            border: 1px solid var(--border);
        }
        .btn-clear:hover { background: var(--surface); color: var(--text); }
        .search-info {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 8px;
        }

        .table-responsive { overflow-x: auto; }
        .users-table {
            width: 100%;
            border-collapse: collapse;
        }
        .users-table th, .users-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .users-table th {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-3);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: var(--surface-2);
            border-bottom: 2px solid var(--border);
        }
        .users-table tbody tr:nth-child(even) {
            background: var(--surface-2);
        }
        .users-table tbody tr:hover {
            background: var(--surface-3);
        }

        .badge-room {
            background: var(--accent-light);
            color: var(--accent);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        .badge-none {
            color: var(--text-3);
            font-style: italic;
            font-size: 12px;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-sm {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-view {
            background: var(--surface-2);
            color: var(--text-2);
            border: 1px solid var(--border);
        }
        .btn-view:hover {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
            transform: translateY(-1px);
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-3);
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h3>All Resident Users</h3>
        </div>

        <!-- Search Section (GET form) -->
        <div class="search-section">
            <form method="GET" action="{{ route('admin.users.index') }}" class="search-form">
                <div class="search-input-wrapper">
                    <input type="text" name="search" placeholder="Search by name or email..." 
                           value="{{ request('search') }}" class="search-input">
                </div>
                <button type="submit" class="btn-search">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="btn-clear">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Clear
                    </a>
                @endif
            </form>
            @if(request('search'))
                <div class="search-info">
                    Showing results for: <strong>{{ request('search') }}</strong>
                </div>
            @endif
        </div>

        <div class="table-responsive">
            @if($users->count() > 0)
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Current Room</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="font-medium">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Joined {{ $user->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->activeAllocation && $user->activeAllocation->room)
                                        <span class="badge-room">Room {{ $user->activeAllocation->room->room_number }}</span>
                                    @else
                                        <span class="badge-none">Not allocated</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn-sm btn-view">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding: 12px 20px; border-top: 1px solid var(--border);">
                    {{ $users->links('components.pagination') }}
                </div>
            @else
                <div class="empty-state">
                    @if(request('search'))
                        <p>No residents found matching "<strong>{{ request('search') }}</strong>".</p>
                        <a href="{{ route('admin.users.index') }}" class="btn-clear" style="display:inline-flex; margin-top:12px;">Clear search</a>
                    @else
                        <p>No residents found.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>