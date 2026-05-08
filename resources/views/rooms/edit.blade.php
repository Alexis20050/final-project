<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:10px;">
            <a href="{{ route('rooms.index') }}" style="display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:7px;border:1px solid var(--border-md);background:var(--surface);color:var(--text-2);text-decoration:none;transition:background .12s;" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='var(--surface)'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">Edit Room</h2>
        </div>
    </x-slot>

    <style>
        /* Same styles as create view – use identical classes */
        .fl{display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start;max-width:880px;}
        @media(max-width:820px){.fl{grid-template-columns:1fr;}}
        .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--r2);overflow:hidden;}
        .card-hd{display:flex;align-items:center;gap:11px;padding:16px 20px;border-bottom:1px solid var(--border);}
        .card-hd-ic{width:34px;height:34px;border-radius:9px;background:var(--accent-bg);display:flex;align-items:center;justify-content:center;}
        .card-hd-ic svg{width:15px;height:15px;color:var(--accent);}
        .card-hd-ttl{font-size:14px;font-weight:600;color:var(--text);margin:0 0 1px;}
        .card-hd-sub{font-size:11.5px;color:var(--text-3);margin:0;}
        .fb{padding:20px;display:flex;flex-direction:column;gap:16px;}
        .field{}
        .fl-label{display:block;font-size:12px;font-weight:600;color:var(--text-2);margin-bottom:5px;letter-spacing:.01em;}
        .fl-label .req{color:var(--red);margin-left:3px;}
        .fl-input,.fl-select{display:block;width:100%;padding:8px 12px;background:var(--surface);border:1px solid var(--border-md);border-radius:var(--r);font-size:13.5px;color:var(--text);outline:none;transition:border-color .15s,box-shadow .15s;}
        .fl-input::placeholder{color:var(--text-3);}
        .fl-input:focus,.fl-select:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(26,86,219,.1);}
        .dark .fl-input,.dark .fl-select{background:var(--surface-2);}
        .fl-select{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:30px;cursor:pointer;}
        .fl-prefix{position:relative;}
        .fl-prefix-sym{position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:13.5px;color:var(--text-3);pointer-events:none;}
        .fl-prefix .fl-input{padding-left:24px;}
        .fl-err{font-size:11.5px;color:var(--red);margin-top:4px;display:flex;align-items:center;gap:4px;}
        .fl-hint{font-size:11.5px;color:var(--text-3);margin-top:4px;}
        .form-foot{padding:14px 20px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:flex-end;gap:8px;background:var(--surface-2);}
        .btn-cancel{padding:8px 15px;border-radius:var(--r);font-size:13px;font-weight:500;color:var(--text-2);background:var(--surface);border:1px solid var(--border-md);text-decoration:none;}
        .btn-cancel:hover{background:var(--surface-2);color:var(--text);}
        .btn-save{display:inline-flex;align-items:center;gap:7px;padding:8px 18px;border-radius:var(--r);font-size:13px;font-weight:600;color:#fff;background:var(--accent);border:none;cursor:pointer;box-shadow:0 1px 4px rgba(26,86,219,.25);transition:opacity .12s;}
        .btn-save:hover{opacity:.87;}
        .btn-save svg{width:14px;height:14px;}
        .current-img{margin-bottom:12px;border-radius:var(--r);background:var(--surface-2);padding:8px;display:inline-block;}
    </style>

    <div class="fl">
        <div class="card">
            <div class="card-hd">
                <div class="card-hd-ic">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <p class="card-hd-ttl">Edit Room</p>
                    <p class="card-hd-sub">Update the room details</p>
                </div>
            </div>

            <form method="POST" action="{{ route('rooms.update', $room) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="fb">
                    <!-- Room Number & Image (side by side) -->
                    <div class="row2">
                        <div class="field">
                            <label for="room_number" class="fl-label">Room Number <span class="req">*</span></label>
                            <input id="room_number" type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" class="fl-input" required>
                            @error('room_number')<p class="fl-err">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="image" class="fl-label">Room Image</label>
                            @if($room->image)
                                <div class="current-img">
                                    <img src="{{ asset('storage/' . $room->image) }}" alt="Current image" style="max-width: 180px; border-radius: var(--r);">
                                    <p class="fl-hint" style="margin-top: 6px;">Current image – upload a new one to replace.</p>
                                </div>
                            @endif
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="fl-input" style="padding: 6px;">
                            <p class="fl-hint">Max 2MB, JPG/PNG/WEBP. Leave empty to keep current image.</p>
                            @error('image')<p class="fl-err">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Price & Status (side by side) -->
                    <div class="row2">
                        <div class="field">
                            <label for="price_per_month" class="fl-label">Price / Month <span class="req">*</span></label>
                            <div class="fl-prefix">
                                <span class="fl-prefix-sym">₱</span>
                                <input id="price_per_month" type="number" step="0.01" min="0" name="price_per_month" value="{{ old('price_per_month', $room->price_per_month) }}" class="fl-input" required>
                            </div>
                            @error('price_per_month')<p class="fl-err">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="status" class="fl-label">Status <span class="req">*</span></label>
                            <select id="status" name="status" class="fl-select" required>
                                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            </select>
                            <p class="fl-hint">Changing status affects room availability for new allocations.</p>
                            @error('status')<p class="fl-err">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-foot">
                    <a href="{{ route('rooms.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Update Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>