{{-- resources/views/rooms/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('rooms.index') }}" 
               style="display:flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:7px; border:1px solid var(--border-md); background:var(--surface); color:var(--text-2); text-decoration:none; transition:background .12s;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">Room {{ $room->room_number }}</h2>
        </div>
    </x-slot>

    <style>
        .room-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
            max-width: 1100px;
        }
        @media (max-width: 800px) {
            .room-layout { grid-template-columns: 1fr; }
        }

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
            font-weight: 600;
            font-size: 14px;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-body {
            padding: 20px;
        }
        .room-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-bottom: 1px solid var(--border);
        }
        .room-image-placeholder {
            width: 100%;
            height: 220px;
            background: var(--surface-2);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-3);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }
        @media (max-width: 500px) {
            .info-grid { grid-template-columns: 1fr; }
        }
        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            align-items: center;
        }
        .info-label {
            width: 130px;
            font-weight: 600;
            color: var(--text-2);
            font-size: 13px;
            flex-shrink: 0;
        }
        .info-value {
            color: var(--text);
            font-size: 14px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-available { background: var(--green-bg); color: var(--green); }
        .status-occupied  { background: var(--accent-bg); color: var(--accent); }
        .status-maintenance { background: var(--amber-bg); color: var(--amber); }
        .status-archived  { background: var(--surface-2); color: var(--text-3); }

        .occupant-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 20px;
        }
        .occupant-name {
            font-weight: 600;
            color: var(--text);
            font-size: 15px;
        }
        .occupant-email {
            color: var(--text-3);
            font-size: 13px;
            margin-top: 2px;
        }
        .occupant-since {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 8px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--r);
            font-size: 13px;
            font-weight: 500;
            border: 1px solid var(--border-md);
            background: var(--surface);
            color: var(--text-2);
            text-decoration: none;
            transition: all .12s;
        }
        .btn-outline:hover {
            background: var(--surface-2);
            color: var(--text);
            border-color: var(--border);
        }
        .btn-danger {
            background: var(--red-bg);
            color: var(--red);
            border: 1px solid var(--red);
            padding: 8px 16px;
            border-radius: var(--r);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
        }
        .btn-danger:hover {
            background: var(--red);
            color: #fff;
        }
        .btn-request {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: var(--r);
            font-size: 14px;
            font-weight: 600;
            background: var(--green-bg);
            color: var(--green);
            border: 1px solid var(--green);
            text-decoration: none;
            transition: all .15s;
        }
        .btn-request:hover {
            background: var(--green);
            color: #fff;
        }
    </style>

    <div class="room-layout">
        {{-- Left: Room Image + Info --}}
        <div class="card">
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" alt="Room {{ $room->room_number }}" class="room-image">
            @else
                <div class="room-image-placeholder">
                    <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            <div class="card-body">
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Room Number</span>
                        <span class="info-value">{{ $room->room_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Type</span>
                        <span class="info-value">{{ ucfirst($room->type) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Capacity</span>
                        <span class="info-value">1 person</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Price</span>
                        <span class="info-value">₱{{ number_format($room->price_per_month, 2) }} / month</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="info-value">
                            <span class="status-badge status-{{ $room->status }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </span>
                    </div>
                    @if($room->building)
                    <div class="info-row">
                        <span class="info-label">Building</span>
                        <span class="info-value">{{ $room->building->name }}</span>
                    </div>
                    @endif
                </div>

                {{-- Admin actions --}}
                @if(auth()->user()?->isAdmin())
                <div class="actions">
                    <a href="{{ route('rooms.edit', $room) }}" class="btn-outline">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Room
                    </a>

                    @if(!$room->archived)
                        <form method="POST" action="{{ route('rooms.archive', $room) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-outline">Archive Room</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('rooms.restore', $room) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-outline">Restore Room</button>
                        </form>
                    @endif

                    @if($activeAllocation)
                        <form method="POST" action="{{ route('rooms.removeResident', $room) }}"
                              onsubmit="return confirm('Evict {{ $activeAllocation->user->name }} from this room?')"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">Remove Resident</button>
                        </form>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Right: Occupant & Student Request --}}
        <div>
            @if($activeAllocation)
                <div class="occupant-card">
                    <div class="card-header" style="border-bottom:0; padding:0 0 12px 0; margin-bottom:12px; background:none; border-bottom:1px solid var(--border);">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Current Resident
                    </div>
                    <div class="occupant-name">{{ $activeAllocation->user->name }}</div>
                    <div class="occupant-email">{{ $activeAllocation->user->email }}</div>
                    <div class="occupant-since">
                        Since {{ \Carbon\Carbon::parse($activeAllocation->start_date)->format('M d, Y') }}
                    </div>
                </div>
            @else
                <div class="occupant-card" style="text-align:center; color: var(--text-3);">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:0.3; margin-bottom:8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p style="font-size:13px; margin:0;">No active resident</p>
                </div>
            @endif

            {{-- Student quick request --}}
            @if(auth()->user()?->isResident() && $room->status === 'available' && !$room->archived)
                <form method="POST" action="{{ route('rooms.request', $room) }}" style="margin-top:16px;">
                    @csrf
                    <button type="submit" class="btn-request" style="width:100%; justify-content:center;">
                        Request This Room
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>