<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="page-header-title">User Management</h2>
            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="'Total: ' + totalUsers + ' residents'">
                Total: {{ $users->total() }} residents
            </div>
        </div>
    </x-slot>

    <style>
        /* ... (keep all existing CSS from previous version, unchanged) ... */
        /* I'll keep the CSS as before – no changes needed */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            overflow: hidden;
            transition: box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: var(--shadow);
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
            position: relative;
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
            transition: all 0.2s ease;
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
        .btn-search:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
        }
        .btn-clear {
            background: var(--surface-2);
            color: var(--text-2);
            border: 1px solid var(--border);
        }
        .btn-clear:hover {
            background: var(--surface);
            color: var(--text);
        }
        .search-info {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 8px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
        }
        .users-table th, .users-table td {
            padding: 14px 16px;
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
        }
        .users-table tr {
            transition: background 0.15s;
        }
        .users-table tr:hover {
            background: var(--surface-2);
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
        .paging {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            background: var(--surface-2);
        }
        .paging button.active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }
        @media (max-width: 640px) {
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
            .btn-search, .btn-clear {
                justify-content: center;
            }
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
        }
        .loading-indicator {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 50%;
            border-top-color: var(--accent);
            animation: spin 0.6s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <div class="card" x-data="{
        searchTerm: '{{ request('search') }}',
        users: @js($users->items()),
        pagination: @js($users->toArray()),
        totalUsers: {{ $users->total() }},
        loading: false,
        debounceTimer: null,
        async fetchUsers(url = null) {
            this.loading = true;
            let fetchUrl = url || `{{ route('admin.users.index') }}?search=${encodeURIComponent(this.searchTerm)}&ajax=1`;
            try {
                const res = await fetch(fetchUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await res.json();
                this.users = data.data;
                this.pagination = data;
                this.totalUsers = data.total;
            } catch (err) {
                console.error(err);
            } finally {
                this.loading = false;
            }
        },
        updateSearch() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.fetchUsers();
            }, 300);
        },
        clearSearch() {
            this.searchTerm = '';
            this.fetchUsers();
        },
        fetchPage(url) {
            if (url) this.fetchUsers(url);
        }
    }" x-init="$watch('searchTerm', () => updateSearch())">

        <div class="card-header">
            <h3>All Resident Users</h3>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-form">
                <div class="search-input-wrapper">
                    <input type="text" placeholder="Search by name, email, or student ID..." 
                           x-model="searchTerm" class="search-input" :class="{ 'loading': loading }">
                </div>
                <button type="button" @click="fetchUsers()" class="btn-search">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                <button type="button" @click="clearSearch()" class="btn-clear" x-show="searchTerm">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Clear
                </button>
            </div>
            <div class="search-info" x-show="searchTerm && !loading">
                Showing results for: <strong x-text="searchTerm"></strong>
            </div>
            <div class="search-info" x-show="loading" style="color: var(--accent); display: flex; gap: 6px; align-items: center;">
                <div class="loading-indicator"></div> Searching...
            </div>
        </div>

        <div class="table-responsive">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Student ID</th>
                        <th>Phone</th>
                        <th>Current Room</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="user in users" :key="user.id">
                        <tr>
                            <td>
                                <div class="font-medium" x-text="user.name"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400" x-text="'Joined ' + new Date(user.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })"></div>
                            </td>
                            <td x-text="user.email"></td>
                            <td x-text="user.student_id || '—'"></td>
                            <td x-text="user.phone || '—'"></td>
                            <td>
                                <span x-show="user.active_allocation && user.active_allocation.room" class="badge-room" x-text="'Room ' + user.active_allocation.room.room_number"></span>
                                <span x-show="!user.active_allocation || !user.active_allocation.room" class="badge-none">Not allocated</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a :href="'{{ url('admin/users') }}/' + user.id" class="btn-sm btn-view">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="users.length === 0 && !loading">
                        <td colspan="6" class="empty-state">
                            <span x-show="searchTerm">No residents found matching <strong x-text="searchTerm"></strong>.</span>
                            <span x-show="!searchTerm">No residents found. <br><span class="text-sm">New residents will appear here after registration.</span></span>
                            <div class="mt-2" x-show="searchTerm">
                                <button @click="clearSearch()" class="btn-clear" style="display:inline-flex;">Clear search</button>
                            </div>
                        </td>
                    </tr>
                    <tr x-show="loading">
                        <td colspan="6" class="empty-state">
                            <div style="display:flex; justify-content:center; align-items:center; gap:8px;">
                                <div class="loading-indicator"></div>
                                <span>Loading...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="paging" x-show="pagination.last_page > 1 && !loading">
            <template x-for="link in pagination.links" :key="link.label">
                <button @click="fetchPage(link.url)" x-html="link.label" :class="{'active': link.active}" style="margin:0 4px; padding:4px 8px; border:1px solid var(--border); background:var(--surface); border-radius:4px; cursor:pointer;"></button>
            </template>
        </div>
    </div>
</x-app-layout>