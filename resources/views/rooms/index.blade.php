<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;width:100%;gap:12px;flex-wrap:wrap;">
            <h2 class="page-header-title">Rooms</h2>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('rooms.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:7px 15px;background:var(--accent);color:#fff;border-radius:var(--r);font-size:13px;font-weight:500;text-decoration:none;box-shadow:0 1px 4px rgba(26,86,219,.25);transition:opacity .15s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                Add Room
            </a>
            @endif
        </div>
    </x-slot>

    <style>
        .badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:99px;font-size:11.5px;font-weight:500;}
        .badge.available{background:var(--green-bg);color:var(--green);}
        .badge.occupied{background:var(--red-bg);color:var(--red);}
        .badge.maintenance{background:var(--amber-bg);color:var(--amber);}

        /* Alert */
        .alert-ok{
            display:flex;align-items:center;gap:9px;
            padding:11px 15px;border-radius:var(--r);
            background:var(--green-bg);color:var(--green);
            border:1px solid rgba(14,159,110,.2);
            font-size:13px;margin-bottom:20px;
        }
        .alert-ok svg{width:15px;height:15px;flex-shrink:0;}

        /* Filters */
        .filters{display:flex;gap:6px;margin-bottom:20px;flex-wrap:wrap;}
        .chip{
            padding:5px 13px;border-radius:99px;font-size:12.5px;font-weight:500;
            border:1px solid var(--border-md);background:var(--surface);color:var(--text-2);
            text-decoration:none;transition:background .12s,color .12s,border-color .12s;
        }
        .chip:hover{background:var(--surface-2);color:var(--text);}
        .chip.on{background:var(--accent);color:#fff;border-color:var(--accent);box-shadow:0 1px 4px rgba(26,86,219,.25);}

        /* Room grid */
        .rg{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;}
        @media(max-width:1050px){.rg{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:640px){.rg{grid-template-columns:1fr;}}

        .rc{
            background:var(--surface);border:1px solid var(--border);
            border-radius:var(--r2);overflow:hidden;display:flex;flex-direction:column;
            transition:box-shadow .2s,border-color .2s,transform .15s;
        }
        .rc:hover{box-shadow:0 4px 20px rgba(0,0,0,.09);border-color:var(--border-md);transform:translateY(-1px);}

        .rc-head{
            padding:14px 16px;border-bottom:1px solid var(--border);
            display:flex;align-items:flex-start;justify-content:space-between;
        }
        .rc-num{font-size:15px;font-weight:700;color:var(--text);letter-spacing:-.3px;font-family:var(--mono);}
        .rc-type{
            font-size:11px;font-weight:500;padding:3px 8px;border-radius:99px;
            background:var(--surface-2);color:var(--text-3);border:1px solid var(--border-md);
            text-transform:capitalize;
        }

        .rc-body{padding:12px 16px;flex:1;display:flex;flex-direction:column;gap:0;}
        .rc-row{
            display:flex;align-items:center;justify-content:space-between;
            padding:7px 0;border-bottom:1px solid var(--border);
        }
        .rc-row:last-child{border-bottom:none;}
        .rc-lbl{font-size:12px;color:var(--text-3);}
        .rc-val{font-size:12.5px;font-weight:500;color:var(--text);}
        .rc-price{font-size:15px;font-weight:700;color:var(--accent-tx);letter-spacing:-.3px;}

        .rc-foot{
            padding:10px 16px;border-top:1px solid var(--border);
            display:flex;align-items:center;justify-content:space-between;
            background:var(--surface-2);
        }
        .rc-view{font-size:12.5px;color:var(--accent-tx);text-decoration:none;font-weight:500;}
        .rc-view:hover{text-decoration:underline;}
        .rc-actions{display:flex;gap:5px;}
        .rc-btn{
            padding:4px 10px;border-radius:6px;font-size:12px;font-weight:500;
            cursor:pointer;text-decoration:none;transition:background .12s;
            border:1px solid var(--border-md);
        }
        .rc-btn.edit{background:var(--surface);color:var(--text-2);}
        .rc-btn.edit:hover{background:var(--surface-2);color:var(--text);}
        .rc-btn.del{background:transparent;color:var(--red);border-color:transparent;}
        .rc-btn.del:hover{background:var(--red-bg);}

        /* Empty */
        .empty{
            grid-column:1/-1;padding:64px 20px;text-align:center;
            background:var(--surface);border:1px solid var(--border);
            border-radius:var(--r2);
        }
        .empty svg{width:44px;height:44px;color:var(--text-3);margin:0 auto 14px;opacity:.35;}
        .empty p{font-size:14px;color:var(--text-2);margin:0 0 16px;}

        /* Pagination */
        .paging{margin-top:24px;}
    </style>

    @if(session('success'))
    <div class="alert-ok">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Filters – Role‑based -->
    <div class="filters">
        @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
            <a href="{{ route('rooms.index') }}" class="chip {{ !request('status') ? 'on' : '' }}">All rooms</a>
            <a href="{{ route('rooms.index', ['status' => 'available']) }}" class="chip {{ request('status') === 'available' ? 'on' : '' }}">Available</a>
            <a href="{{ route('rooms.index', ['status' => 'occupied']) }}" class="chip {{ request('status') === 'occupied' ? 'on' : '' }}">Occupied</a>
            <a href="{{ route('rooms.index', ['status' => 'maintenance']) }}" class="chip {{ request('status') === 'maintenance' ? 'on' : '' }}">Maintenance</a>
        @else
            <!-- Students see only available rooms, so no filter needed -->
            <span class="chip on">Available rooms</span>
        @endif
    </div>

    <!-- Grid -->
    <div class="rg">
        @forelse($rooms as $room)
        <div class="rc">
            <!-- ========== IMAGE THUMBNAIL ========== -->
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" alt="Room {{ $room->room_number }}" style="width:100%; height:140px; object-fit:cover; border-bottom:1px solid var(--border);">
            @else
                <div style="width:100%; height:140px; background:var(--surface-2); display:flex; align-items:center; justify-content:center; border-bottom:1px solid var(--border);">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif
            <!-- =================================== -->
            <div class="rc-head">
                <div>
                    <div class="rc-num">{{ $room->room_number }}</div>
                    <div style="margin-top:5px;"><span class="badge {{ $room->status }}">{{ ucfirst($room->status) }}</span></div>
                </div>
                <span class="rc-type">{{ ucfirst($room->type) }}</span>
            </div>
            <div class="rc-body">
                <div class="rc-row">
                    <span class="rc-lbl">Capacity</span>
                    <span class="rc-val">{{ $room->capacity }} person{{ $room->capacity > 1 ? 's' : '' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-lbl">Monthly rate</span>
                    <span class="rc-price">₱{{ number_format($room->price_per_month, 0) }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-lbl">Added</span>
                    <span class="rc-val">{{ $room->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="rc-foot">
                <a href="{{ route('rooms.show', $room) }}" class="rc-view">View details →</a>
                @if(auth()->user()->isAdmin())
                <div class="rc-actions">
                    <a href="{{ route('rooms.edit', $room) }}" class="rc-btn edit">Edit</a>
                    <form method="POST" action="{{ route('rooms.destroy', $room) }}" onsubmit="return confirm('Delete room {{ $room->room_number }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="rc-btn del">Delete</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
            @if(auth()->user()->isResident())
                <p>No available rooms at the moment. Please check back later.</p>
            @else
                <p>No rooms found{{ request('status') ? ' with status "'.request('status').'"' : '' }}.</p>
            @endif
            @if(auth()->user()->isAdmin())
                <a href="{{ route('rooms.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:var(--accent);color:#fff;border-radius:var(--r);font-size:13px;font-weight:500;text-decoration:none;">
                    + Add your first room
                </a>
            @endif
        </div>
        @endforelse
    </div>

    <div class="paging">{{ $rooms->links() }}</div>
</x-app-layout>