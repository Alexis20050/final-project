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
        .detail-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 24px;
            margin-bottom: 24px;
        }
        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }
        .detail-label {
            width: 150px;
            font-weight: 600;
            color: var(--text-2);
        }
        .detail-value {
            flex: 1;
            color: var(--text);
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
        }
        .badge-available { background: var(--green-bg); color: var(--green); }
        .badge-occupied  { background: var(--accent-bg); color: var(--accent); }
        .badge-maintenance { background: var(--amber-bg); color: var(--amber); }
        .badge-archived  { background: var(--surface-2); color: var(--text-3); }

        .action-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn-danger {
            background: var(--red);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: var(--r);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-danger:hover {
            background: #c53030;
        }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-md);
            color: var(--text-2);
            padding: 8px 16px;
            border-radius: var(--r);
            font-size: 14px;
            text-decoration: none;
        }
        .btn-outline:hover {
            background: var(--surface-2);
            color: var(--text);
        }
        .occupant-info {
            background: var(--surface-2);
            padding: 12px 16px;
            border-radius: var(--r);
            margin-top: 16px;
            font-size: 14px;
        }
    </style>

    <div class="detail-card">
        <div class="detail-row">
            <div class="detail-label">Room Number</div>
            <div class="detail-value">{{ $room->room_number }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Type</div>
            <div class="detail-value">{{ ucfirst($room->type) }}</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Capacity</div>
            <div class="detail-value">{{ $room->capacity }} person(s)</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Price</div>
            <div class="detail-value">₱{{ number_format($room->price_per_month, 2) }} / month</div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                <span class="badge badge-{{ $room->status }}">
                    {{ ucfirst($room->status) }}
                </span>
            </div>
        </div>
        @if($room->building)
        <div class="detail-row">
            <div class="detail-label">Building</div>
            <div class="detail-value">{{ $room->building->name }}</div>
        </div>
        @endif

        {{-- Current occupant (if any) --}}
        @if($activeAllocation)
        <div class="occupant-info">
            <strong>Current Resident:</strong>
            {{ $activeAllocation->user->name }} ({{ $activeAllocation->user->email }})
            <br>
            <span style="font-size:12px; color: var(--text-3);">
                Since {{ \Carbon\Carbon::parse($activeAllocation->start_date)->format('M d, Y') }}
            </span>
        </div>
        @endif

        {{-- Admin actions --}}
        @if(auth()->user()?->isAdmin())
        <div class="action-buttons">
            <a href="{{ route('rooms.edit', $room) }}" class="btn-outline">Edit Room</a>

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

            {{-- 🔴 Remove Resident (visible only if active allocation exists) --}}
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

    {{-- Student quick request --}}
    @if(auth()->user()?->isResident() && $room->status === 'available')
        <div style="margin-top:16px;">
            <form method="POST" action="{{ route('rooms.request', $room) }}">
                @csrf
                <button type="submit" class="btn-primary">Request This Room</button>
            </form>
        </div>
    @endif
</x-app-layout> 