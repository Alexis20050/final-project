<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:10px;">
            <a href="{{ route('rooms.index') }}" style="display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:7px;border:1px solid var(--border-md);background:var(--surface);color:var(--text-2);text-decoration:none;transition:background .12s;" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='var(--surface)'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">Room {{ $room->room_number }}</h2>
            <span style="display:inline-flex;align-items:center;padding:3px 9px;border-radius:99px;font-size:11.5px;font-weight:500;
                @if($room->status=='available') background:var(--green-bg);color:var(--green);
                @elseif($room->status=='occupied') background:var(--red-bg);color:var(--red);
                @else background:var(--amber-bg);color:var(--amber); @endif">
                {{ ucfirst($room->status) }}
            </span>
        </div>
    </x-slot>

    <style>
        .dl{display:grid;grid-template-columns:1fr 272px;gap:20px;align-items:start;}
        @media(max-width:820px){.dl{grid-template-columns:1fr;}}

        .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--r2);overflow:hidden;}
        .card-hd{padding:14px 20px;border-bottom:1px solid var(--border);}
        .card-hd-lbl{font-size:10.5px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--text-3);margin:0;}

        /* Headline block */
        .room-hl{
            padding:22px 22px 18px;background:var(--surface-2);
            border-bottom:1px solid var(--border);
        }
        .rhl-num{font-size:36px;font-weight:800;letter-spacing:-.05em;color:var(--text);font-family:var(--mono);margin:0 0 10px;}
        .rhl-tags{display:flex;gap:7px;flex-wrap:wrap;}
        .rhl-tag{
            display:inline-flex;align-items:center;gap:5px;
            padding:4px 11px;border-radius:99px;font-size:12px;font-weight:500;
        }
        .rhl-tag.st-available{background:var(--green-bg);color:var(--green);}
        .rhl-tag.st-occupied{background:var(--red-bg);color:var(--red);}
        .rhl-tag.st-maintenance{background:var(--amber-bg);color:var(--amber);}
        .rhl-tag.type{background:var(--surface);color:var(--text-2);border:1px solid var(--border-md);text-transform:capitalize;}
        .tag-dot{width:6px;height:6px;border-radius:50%;background:currentColor;}

        /* Specs 2x2 */
        .specs{display:grid;grid-template-columns:1fr 1fr;}
        .spec-cell{
            padding:16px 20px;
            border-bottom:1px solid var(--border);
            border-right:1px solid var(--border);
        }
        .spec-cell:nth-child(2n){border-right:none;}
        .spec-cell:nth-last-child(-n+2){border-bottom:none;}
        .sp-lbl{font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--text-3);margin-bottom:5px;}
        .sp-val{font-size:16px;font-weight:600;color:var(--text);}
        .sp-val.price{color:var(--accent-tx);font-size:20px;letter-spacing:-.4px;}

        /* Meta rows */
        .meta-row{
            display:flex;align-items:center;justify-content:space-between;
            padding:10px 20px;border-bottom:1px solid var(--border);font-size:13px;
        }
        .meta-row:last-child{border-bottom:none;}
        .meta-lbl{color:var(--text-3);}
        .meta-val{color:var(--text-2);font-family:var(--mono);font-size:12px;}

        /* Action buttons */
        .ac-body{padding:14px;}
        .btn-block{
            display:flex;align-items:center;justify-content:center;gap:7px;
            width:100%;padding:9px 16px;border-radius:var(--r);
            font-size:13px;font-weight:500;cursor:pointer;
            text-decoration:none;border:none;
            transition:opacity .12s,background .12s;
        }
        .btn-block svg{width:14px;height:14px;}
        .btn-primary{background:var(--accent);color:#fff;margin-bottom:7px;box-shadow:0 1px 4px rgba(26,86,219,.2);}
        .btn-primary:hover{opacity:.87;}
        .btn-danger{background:transparent;color:var(--red);border:1px solid var(--border-md);}
        .btn-danger:hover{background:var(--red-bg);border-color:transparent;}

        /* Info list */
        .info-list{display:flex;flex-direction:column;}
        .info-item{display:flex;gap:10px;padding:12px 16px;border-bottom:1px solid var(--border);align-items:center;}
        .info-item:last-child{border-bottom:none;}
        .info-ic{width:28px;height:28px;border-radius:7px;background:var(--surface-2);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
        .info-ic svg{width:13px;height:13px;color:var(--text-2);}
        .info-lbl{font-size:11px;color:var(--text-3);margin-bottom:2px;}
        .info-val{font-size:13px;font-weight:600;color:var(--text);}
    </style>

    <div class="dl">
        <!-- Main info -->
        <div class="card">
            <!-- ========== ROOM IMAGE (ADDED) ========== -->
            @if($room->image)
                <div style="max-height: 300px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $room->image) }}" alt="Room {{ $room->room_number }}" style="width:100%; object-fit:cover;">
                </div>
            @endif
            <!-- ======================================= -->
            <div class="room-hl">
                <p class="rhl-num">{{ $room->room_number }}</p>
                <div class="rhl-tags">
                    <span class="rhl-tag st-{{ $room->status }}"><span class="tag-dot"></span>{{ ucfirst($room->status) }}</span>
                    <span class="rhl-tag type">{{ ucfirst($room->type) }}</span>
                </div>
            </div>

            <div class="specs">
                <div class="spec-cell">
                    <div class="sp-lbl">Capacity</div>
                    <div class="sp-val">{{ $room->capacity }} person{{ $room->capacity > 1 ? 's' : '' }}</div>
                </div>
                <div class="spec-cell">
                    <div class="sp-lbl">Monthly Rate</div>
                    <div class="sp-val price">₱{{ number_format($room->price_per_month, 2) }}</div>
                </div>
                <div class="spec-cell">
                    <div class="sp-lbl">Type</div>
                    <div class="sp-val" style="text-transform:capitalize;font-size:15px;">{{ $room->type }}</div>
                </div>
                <div class="spec-cell">
                    <div class="sp-lbl">Status</div>
                    <div class="sp-val" style="text-transform:capitalize;font-size:15px;">{{ $room->status }}</div>
                </div>
            </div>

            <div>
                <div class="meta-row">
                    <span class="meta-lbl">Room ID</span>
                    <span class="meta-val">#{{ str_pad($room->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-lbl">Created</span>
                    <span class="meta-val">{{ $room->created_at->format('M d, Y · h:i A') }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-lbl">Last updated</span>
                    <span class="meta-val">{{ $room->updated_at->format('M d, Y · h:i A') }}</span>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div style="display:flex;flex-direction:column;gap:16px;">
            @auth @if(auth()->user()->role === 'admin')
            <div class="card">
                <div class="card-hd"><p class="card-hd-lbl">Admin Actions</p></div>
                <div class="ac-body">
                    <a href="{{ route('rooms.edit', $room) }}" class="btn-block btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Room
                    </a>
                    <form method="POST" action="{{ route('rooms.destroy', $room) }}" onsubmit="return confirm('Permanently delete room {{ $room->room_number }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-block btn-danger">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete Room
                        </button>
                    </form>
                </div>
            </div>
            @endif @endauth

            <div class="card">
                <div class="card-hd"><p class="card-hd-lbl">Room Summary</p></div>
                <div class="info-list">
                    <div class="info-item">
                        <div class="info-ic"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg></div>
                        <div><div class="info-lbl">Room number</div><div class="info-val">{{ $room->room_number }}</div></div>
                    </div>
                    <div class="info-item">
                        <div class="info-ic"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                        <div><div class="info-lbl">Capacity</div><div class="info-val">{{ $room->capacity }} person{{ $room->capacity > 1 ? 's' : '' }}</div></div>
                    </div>
                    <div class="info-item">
                        <div class="info-ic"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/></svg></div>
                        <div><div class="info-lbl">Monthly rate</div><div class="info-val">₱{{ number_format($room->price_per_month, 2) }}</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>