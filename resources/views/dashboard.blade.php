<x-app-layout>
    <x-slot name="header">
        <h2 class="page-header-title">Dashboard</h2>
    </x-slot>

    <style>
        /* ── Shared tokens ── */
        .badge { display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:99px;font-size:11.5px;font-weight:500; }
        .badge.available  { background:var(--green-bg);color:var(--green); }
        .badge.occupied   { background:var(--red-bg);color:var(--red); }
        .badge.maintenance{ background:var(--amber-bg);color:var(--amber); }
        .card { background:var(--surface);border:1px solid var(--border);border-radius:var(--r2);overflow:hidden; }
        .card-hd {
            display:flex;align-items:center;justify-content:space-between;
            padding:14px 20px;border-bottom:1px solid var(--border);
        }
        .card-hd-title { font-size:13.5px;font-weight:600;color:var(--text);margin:0; }
        .card-hd-link { font-size:12.5px;color:var(--accent-tx);text-decoration:none; }
        .card-hd-link:hover { text-decoration:underline; }

        /* ── Hero ── */
        .hero {
            background:#0F0E09;
            border-radius:var(--r3);
            padding:28px 32px;
            margin-bottom:24px;
            position:relative;overflow:hidden;
            border:1px solid rgba(255,255,255,.07);
        }
        .hero::before {
            content:'';position:absolute;top:-80px;right:-60px;
            width:280px;height:280px;border-radius:50%;
            background:radial-gradient(circle,rgba(26,86,219,.25) 0%,transparent 70%);
            pointer-events:none;
        }
        .hero-greeting { font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:#60A5FA;font-weight:600;margin-bottom:6px; }
        .hero-name { font-size:22px;font-weight:700;color:#F0EEE8;letter-spacing:-.4px;margin:0 0 6px; }
        .hero-sub  { font-size:13px;color:#5B5950;margin:0 0 16px;font-weight:300; }
        .hero-role {
            display:inline-flex;align-items:center;gap:6px;
            padding:4px 12px;border-radius:99px;
            background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.09);
            font-size:12px;color:#9A9890;text-transform:capitalize;
        }
        .hero-role-dot { width:6px;height:6px;border-radius:50%;background:#60A5FA; }

        /* ── Stats grid ── */
        .stats-grid {
            display:grid;grid-template-columns:repeat(4,minmax(0,1fr));
            gap:14px;margin-bottom:24px;
        }
        @media(max-width:900px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:480px){.stats-grid{grid-template-columns:1fr;}}

        .stat {
            background:var(--surface);border:1px solid var(--border);
            border-radius:var(--r2);padding:18px;
            display:flex;flex-direction:column;gap:10px;
            transition:box-shadow .2s,border-color .2s;
        }
        .stat:hover{box-shadow:var(--shadow);border-color:var(--border-md);}
        .stat-top{display:flex;align-items:flex-start;justify-content:space-between;}
        .stat-icon{
            width:36px;height:36px;border-radius:9px;
            display:flex;align-items:center;justify-content:center;
        }
        .stat-icon svg{width:16px;height:16px;}
        .si-blue  {background:var(--accent-bg);color:var(--accent);}
        .si-green {background:var(--green-bg);color:var(--green);}
        .si-red   {background:var(--red-bg);color:var(--red);}
        .si-amber {background:var(--amber-bg);color:var(--amber);}
        .stat-label{font-size:11.5px;color:var(--text-3);font-weight:500;}
        .stat-val{font-size:30px;font-weight:700;letter-spacing:-.04em;line-height:1;font-family:var(--mono);}
        .sv-blue  {color:var(--accent-tx);}
        .sv-green {color:var(--green);}
        .sv-red   {color:var(--red);}
        .sv-amber {color:var(--amber);}
        .stat-footer{font-size:11.5px;color:var(--text-3);}

        /* ── Bottom two-col ── */
        .bottom-grid{display:grid;grid-template-columns:1fr 280px;gap:20px;}
        @media(max-width:900px){.bottom-grid{grid-template-columns:1fr;}}

        /* Room list rows */
        .room-row{
            display:flex;align-items:center;justify-content:space-between;
            padding:12px 20px;border-bottom:1px solid var(--border);
            transition:background .12s;
        }
        .room-row:last-child{border-bottom:none;}
        .room-row:hover{background:var(--surface-2);}
        .rr-num{font-size:13px;font-weight:600;color:var(--text);font-family:var(--mono);}
        .rr-meta{font-size:11.5px;color:var(--text-3);margin-top:2px;}
        .rr-right{display:flex;align-items:center;gap:10px;}
        .rr-price{font-size:12.5px;font-weight:500;color:var(--text-2);}
        .rr-view{font-size:12px;color:var(--accent-tx);text-decoration:none;opacity:0;transition:opacity .12s;}
        .room-row:hover .rr-view{opacity:1;}

        /* Occupancy */
        .occ-body{padding:16px 20px;display:flex;flex-direction:column;gap:12px;}
        .occ-track{height:5px;background:var(--surface-2);border-radius:99px;overflow:hidden;}
        .occ-fill{height:100%;border-radius:99px;background:var(--red);transition:width .4s;}
        .occ-rows{display:flex;flex-direction:column;gap:8px;}
        .occ-row{display:flex;align-items:center;gap:8px;font-size:12.5px;}
        .occ-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}
        .occ-lbl{flex:1;color:var(--text-2);}
        .occ-val{font-weight:600;color:var(--text);font-family:var(--mono);font-size:13px;}

        /* Quick actions */
        .qa-body{padding:12px;display:flex;flex-direction:column;gap:6px;}
        .qa-btn{
            display:flex;align-items:center;gap:10px;
            padding:11px 13px;border-radius:var(--r);
            background:var(--surface-2);border:1px solid var(--border);
            color:var(--text);text-decoration:none;font-size:13px;font-weight:500;
            transition:background .12s,border-color .12s;
        }
        .qa-btn:hover{background:var(--surface);border-color:var(--border-md);}
        .qa-btn svg{width:15px;height:15px;color:var(--text-3);}
        .qa-arr{margin-left:auto;font-size:12px;color:var(--text-3);}

        /* Empty */
        .empty{padding:40px;text-align:center;color:var(--text-3);font-size:13.5px;}
        .empty svg{width:40px;height:40px;margin:0 auto 12px;opacity:.3;}

        /* Admin quick access banner */
        .admin-bar {
            background:var(--accent-bg);border:1px solid rgba(26,86,219,.15);
            border-radius:var(--r2);padding:14px 18px;
            display:flex;align-items:center;gap:12px;
            margin-bottom:20px;
        }
        .admin-bar-icon{width:32px;height:32px;border-radius:8px;background:var(--accent);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
        .admin-bar-icon svg{width:14px;height:14px;color:#fff;}
        .admin-bar-text{flex:1;}
        .admin-bar-title{font-size:13px;font-weight:600;color:var(--accent-tx);}
        .admin-bar-sub{font-size:12px;color:var(--text-3);margin-top:1px;}
        .admin-bar-cta{
            padding:6px 14px;border-radius:var(--r);
            background:var(--accent);color:#fff;text-decoration:none;
            font-size:12.5px;font-weight:500;white-space:nowrap;
            transition:opacity .15s;
        }
        .admin-bar-cta:hover{opacity:.85;}
    </style>

    @php
        $total       = \App\Models\Room::count();
        $available   = \App\Models\Room::where('status','available')->count();
        $occupied    = \App\Models\Room::where('status','occupied')->count();
        $maintenance = \App\Models\Room::where('status','maintenance')->count();
        $rate = $total > 0 ? round(($occupied / $total) * 100) : 0;
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    @endphp

    <!-- Hero -->
    <div class="hero">
        <p class="hero-greeting">{{ $greeting }}</p>
        <h2 class="hero-name">{{ auth()->user()->name }}</h2>
        <p class="hero-sub">Here's your dormitory overview for {{ now()->format('l, F j') }}.</p>
        <span class="hero-role">
            <span class="hero-role-dot"></span>
            {{ auth()->user()->role }}
        </span>
    </div>

    @if(auth()->user()->isAdmin())
    <div class="admin-bar">
        <div class="admin-bar-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <div class="admin-bar-text">
            <div class="admin-bar-title">Admin access</div>
            <div class="admin-bar-sub">You can create, edit, and delete rooms</div>
        </div>
        <a href="{{ route('rooms.create') }}" class="admin-bar-cta">+ Add room</a>
    </div>
    @endif

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Total Rooms</div><div class="stat-val sv-blue">{{ $total }}</div></div>
                <div class="stat-icon si-blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                </div>
            </div>
            <div class="stat-footer">All registered units</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Available</div><div class="stat-val sv-green">{{ $available }}</div></div>
                <div class="stat-icon si-green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Ready to rent out</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Occupied</div><div class="stat-val sv-red">{{ $occupied }}</div></div>
                <div class="stat-icon si-red">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
            <div class="stat-footer">{{ $rate }}% occupancy rate</div>
        </div>
        <div class="stat">
            <div class="stat-top">
                <div><div class="stat-label">Maintenance</div><div class="stat-val sv-amber">{{ $maintenance }}</div></div>
                <div class="stat-icon si-amber">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Under service</div>
        </div>
    </div>

    <!-- Bottom grid -->
    <div class="bottom-grid">
        <!-- Recent Rooms -->
        <div class="card">
            <div class="card-hd">
                <h3 class="card-hd-title">Recently Added Rooms</h3>
                <a href="{{ route('rooms.index') }}" class="card-hd-link">View all →</a>
            </div>
            @forelse(\App\Models\Room::latest()->take(6)->get() as $room)
            <div class="room-row">
                <div>
                    <div class="rr-num">{{ $room->room_number }}</div>
                    <div class="rr-meta">{{ ucfirst($room->type) }} · {{ $room->capacity }} person(s)</div>
                </div>
                <div class="rr-right">
                    <div style="text-align:right;">
                        <div class="rr-price">₱{{ number_format($room->price_per_month, 0) }}/mo</div>
                        <div style="margin-top:4px;"><span class="badge {{ $room->status }}">{{ ucfirst($room->status) }}</span></div>
                    </div>
                    <a href="{{ route('rooms.show', $room) }}" class="rr-view">→</a>
                </div>
            </div>
            @empty
            <div class="empty">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                No rooms have been added yet.
            </div>
            @endforelse
        </div>

        <!-- Right column -->
        <div style="display:flex;flex-direction:column;gap:16px;">
            <!-- Occupancy -->
            <div class="card">
                <div class="card-hd">
                    <h3 class="card-hd-title">Occupancy</h3>
                    @if($total > 0)<span style="font-size:13px;font-weight:700;color:var(--text);font-family:var(--mono);">{{ $rate }}%</span>@endif
                </div>
                <div class="occ-body">
                    @if($total > 0)
                    <div class="occ-track"><div class="occ-fill" style="width:{{ $rate }}%"></div></div>
                    @endif
                    <div class="occ-rows">
                        <div class="occ-row"><div class="occ-dot" style="background:var(--green)"></div><span class="occ-lbl">Available</span><span class="occ-val">{{ $available }}</span></div>
                        <div class="occ-row"><div class="occ-dot" style="background:var(--red)"></div><span class="occ-lbl">Occupied</span><span class="occ-val">{{ $occupied }}</span></div>
                        <div class="occ-row"><div class="occ-dot" style="background:var(--amber)"></div><span class="occ-lbl">Maintenance</span><span class="occ-val">{{ $maintenance }}</span></div>
                    </div>
                </div>
            </div>

            @if(auth()->user()->isAdmin())
            <!-- Quick actions -->
            <div class="card">
                <div class="card-hd"><h3 class="card-hd-title">Quick Actions</h3></div>
                <div class="qa-body">
                    <a href="{{ route('rooms.create') }}" class="qa-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 5v14M5 12h14"/></svg>
                        Add New Room
                        <span class="qa-arr">→</span>
                    </a>
                    <a href="{{ route('rooms.index') }}" class="qa-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        Manage Rooms
                        <span class="qa-arr">→</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>