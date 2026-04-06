<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:10px;">
            <a href="{{ route('rooms.index') }}" style="display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:7px;border:1px solid var(--border-md);background:var(--surface);color:var(--text-2);text-decoration:none;transition:background .12s;" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='var(--surface)'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">Add New Room</h2>
        </div>
    </x-slot>

    <style>
        .fl{display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start;max-width:880px;}
        @media(max-width:820px){.fl{grid-template-columns:1fr;}}

        .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--r2);overflow:hidden;}
        .card-hd{
            display:flex;align-items:center;gap:11px;
            padding:16px 20px;border-bottom:1px solid var(--border);
        }
        .card-hd-ic{
            width:34px;height:34px;border-radius:9px;
            background:var(--accent-bg);display:flex;align-items:center;justify-content:center;
        }
        .card-hd-ic svg{width:15px;height:15px;color:var(--accent);}
        .card-hd-ttl{font-size:14px;font-weight:600;color:var(--text);margin:0 0 1px;}
        .card-hd-sub{font-size:11.5px;color:var(--text-3);margin:0;}

        /* Form */
        .fb{padding:20px;display:flex;flex-direction:column;gap:16px;}
        .row2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
        @media(max-width:540px){.row2{grid-template-columns:1fr;}}

        .field{}
        .fl-label{
            display:block;font-size:12px;font-weight:600;
            color:var(--text-2);margin-bottom:5px;letter-spacing:.01em;
        }
        .fl-label .req{color:var(--red);margin-left:3px;}

        .fl-input,.fl-select{
            display:block;width:100%;padding:8px 12px;
            background:var(--surface);border:1px solid var(--border-md);
            border-radius:var(--r);font-size:13.5px;color:var(--text);
            font-family:var(--font);outline:none;
            transition:border-color .15s,box-shadow .15s;
            -webkit-appearance:none;
        }
        .fl-input::placeholder{color:var(--text-3);}
        .fl-input:focus,.fl-select:focus{
            border-color:var(--accent);
            box-shadow:0 0 0 3px rgba(26,86,219,.1);
        }
        .dark .fl-input,.dark .fl-select{background:var(--surface-2);}
        .fl-select{
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat:no-repeat;background-position:right 10px center;
            padding-right:30px;cursor:pointer;
        }
        .fl-prefix{
            position:relative;
        }
        .fl-prefix-sym{
            position:absolute;left:11px;top:50%;transform:translateY(-50%);
            font-size:13.5px;color:var(--text-3);pointer-events:none;
        }
        .fl-prefix .fl-input{padding-left:24px;}

        .fl-err{font-size:11.5px;color:var(--red);margin-top:4px;display:flex;align-items:center;gap:4px;}
        .fl-hint{font-size:11.5px;color:var(--text-3);margin-top:4px;}

        /* Footer */
        .form-foot{
            padding:14px 20px;border-top:1px solid var(--border);
            display:flex;align-items:center;justify-content:flex-end;gap:8px;
            background:var(--surface-2);
        }
        .btn-cancel{
            padding:8px 15px;border-radius:var(--r);
            font-size:13px;font-weight:500;color:var(--text-2);
            background:var(--surface);border:1px solid var(--border-md);
            text-decoration:none;cursor:pointer;transition:background .12s;
        }
        .btn-cancel:hover{background:var(--surface-2);color:var(--text);}
        .btn-save{
            display:inline-flex;align-items:center;gap:7px;
            padding:8px 18px;border-radius:var(--r);
            font-size:13px;font-weight:600;color:#fff;
            background:var(--accent);border:none;cursor:pointer;
            box-shadow:0 1px 4px rgba(26,86,219,.25);
            transition:opacity .12s;
        }
        .btn-save:hover{opacity:.87;}
        .btn-save svg{width:14px;height:14px;}

        /* Tips */
        .tips{}
        .tip{
            display:flex;gap:10px;padding:13px 16px;
            border-bottom:1px solid var(--border);align-items:flex-start;
        }
        .tip:last-child{border-bottom:none;}
        .tip-ic{
            width:28px;height:28px;border-radius:7px;background:var(--surface-2);
            display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;
        }
        .tip-ic svg{width:13px;height:13px;color:var(--text-2);}
        .tip-ttl{font-size:12.5px;font-weight:600;color:var(--text);margin-bottom:2px;}
        .tip-desc{font-size:12px;color:var(--text-3);line-height:1.55;}
    </style>

    <div class="fl">
        <!-- Form card -->
        <div class="card">
            <div class="card-hd">
                <div class="card-hd-ic">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                </div>
                <div>
                    <p class="card-hd-ttl">Room Details</p>
                    <p class="card-hd-sub">Fields marked * are required</p>
                </div>
            </div>

            <form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="fb">

                    <div class="row2">
                        <div class="field">
                            <label for="room_number" class="fl-label">Room Number <span class="req">*</span></label>
                            <input id="room_number" type="text" name="room_number"
                                value="{{ old('room_number') }}"
                                placeholder="e.g. 101, A-04"
                                class="fl-input" required autofocus>
                            @error('room_number')<p class="fl-err">{{ $message }}</p>@enderror
                                <div class="field">
    <label for="image" class="fl-label">Room Image</label>
    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="fl-input" style="padding: 6px;">
    <p class="fl-hint">Optional. Upload a picture of the room (max 2MB, JPG/PNG/WEBP).</p>
    @error('image')
        <p class="fl-err">{{ $message }}</p>
    @enderror
</div>
                        </div>
                        <div class="field">
                            <label for="type" class="fl-label">Room Type <span class="req">*</span></label>
                            <select id="type" name="type" class="fl-select" required>
                                <option value="">Select type…</option>
                                <option value="single" {{ old('type')=='single' ? 'selected' : '' }}>Single</option>
                                <option value="double" {{ old('type')=='double' ? 'selected' : '' }}>Double</option>
                                <option value="dormitory" {{ old('type')=='dormitory' ? 'selected' : '' }}>Dormitory</option>
                            </select>
                            @error('type')<p class="fl-err">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="row2">
                        <div class="field">
                            <label for="capacity" class="fl-label">Capacity <span class="req">*</span></label>
                            <input id="capacity" type="number" name="capacity" min="1"
                                value="{{ old('capacity') }}"
                                placeholder="Number of occupants"
                                class="fl-input" required>
                            @error('capacity')<p class="fl-err">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="price_per_month" class="fl-label">Price / Month <span class="req">*</span></label>
                            <div class="fl-prefix">
                                <span class="fl-prefix-sym">₱</span>
                                <input id="price_per_month" type="number" step="0.01" min="0" name="price_per_month"
                                    value="{{ old('price_per_month') }}"
                                    placeholder="0.00"
                                    class="fl-input" required>
                            </div>
                            @error('price_per_month')<p class="fl-err">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="field">
                        <label for="status" class="fl-label">Initial Status <span class="req">*</span></label>
                        <select id="status" name="status" class="fl-select" required>
                            <option value="available" {{ old('status','available')=='available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ old('status')=='occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="maintenance" {{ old('status')=='maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                        </select>
                        <p class="fl-hint">You can update this status anytime from the edit screen.</p>
                        @error('status')<p class="fl-err">{{ $message }}</p>@enderror
                    </div>

                </div>
                <div class="form-foot">
                    <a href="{{ route('rooms.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Save Room
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="card">
            <div style="padding:12px 16px;border-bottom:1px solid var(--border);">
                <p style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.07em;color:var(--text-3);margin:0;">Setup Tips</p>
            </div>
            <div class="tips">
                <div class="tip">
                    <div class="tip-ic"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 20l4-16m2 16l4-16"/></svg></div>
                    <div><div class="tip-ttl">Consistent numbering</div><div class="tip-desc">Use a floor-room pattern like 1-01 or 3-12 for easy sorting.</div></div>
                </div>
                <div class="tip">
                    <div class="tip-ic"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <div><div class="tip-ttl">Accurate capacity</div><div class="tip-desc">Set the exact number of beds or sleeping spots in the room.</div></div>
                </div>
                <div class="tip">
                    <div class="tip-ic"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/></svg></div>
                    <div><div class="tip-ttl">Fair pricing</div><div class="tip-desc">Check local dorm rates before setting a monthly price.</div></div>
                </div>
                <div class="tip">
                    <div class="tip-ic"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div><div class="tip-ttl">Start Available</div><div class="tip-desc">New rooms should default to Available unless already occupied.</div></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>