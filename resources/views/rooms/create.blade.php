<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('rooms.index') }}"
               style="display:flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:7px; border:1px solid var(--border-md); background:var(--surface); color:var(--text-2); text-decoration:none; transition:background .12s;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">Add New Room</h2>
        </div>
    </x-slot>

    <style>
        /* ── Layout ── */
        .form-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 24px;
            align-items: start;
            max-width: 960px;
        }
        @media (max-width: 820px) {
            .form-layout { grid-template-columns: 1fr; }
        }

        /* ── Cards ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r3);
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,.03);
        }
        .card-header {
            display: flex; align-items: center; gap: 12px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }
        .card-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--accent-bg);
            display: flex; align-items: center; justify-content: center;
        }
        .card-icon svg { width: 16px; height: 16px; color: var(--accent); }
        .card-title {
            font-size: 15px; font-weight: 600; color: var(--text);
            margin: 0 0 2px; letter-spacing: -.01em;
        }
        .card-subtitle {
            font-size: 12px; color: var(--text-3); margin: 0;
        }

        .card-body {
            padding: 20px;
            display: flex; flex-direction: column; gap: 20px;
        }

        /* ── Form fields ── */
        .field { }
        .field-label {
            display: block; font-size: 13px; font-weight: 600;
            color: var(--text-2); margin-bottom: 6px;
            letter-spacing: .01em;
        }
        .field-label .required { color: var(--red); margin-left: 3px; }
        .field-input, .field-select {
            display: block; width: 100%; padding: 10px 14px;
            background: var(--surface); border: 1px solid var(--border-md);
            border-radius: var(--r); font-size: 14px; color: var(--text);
            outline: none; transition: all .15s;
            font-family: var(--font);
        }
        .field-input::placeholder { color: var(--text-3); }
        .field-input:focus, .field-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(26,86,219,.12);
        }
        .dark .field-input, .dark .field-select { background: var(--surface-2); }
        .field-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center;
            padding-right: 36px; cursor: pointer; appearance: none;
        }
        .price-wrapper {
            position: relative;
        }
        .price-symbol {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%); font-size: 14px;
            color: var(--text-3); pointer-events: none;
            font-weight: 500;
        }
        .price-wrapper .field-input { padding-left: 32px; }

        .field-error {
            font-size: 12px; color: var(--red); margin-top: 5px;
            display: flex; align-items: center; gap: 4px;
        }
        .field-hint {
            font-size: 12px; color: var(--text-3); margin-top: 6px;
        }

        /* Two‑column row inside form */
        .row2 {
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
        }
        @media (max-width: 500px) { .row2 { grid-template-columns: 1fr; } }

        .form-footer {
            padding: 14px 20px; border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: flex-end;
            gap: 10px; background: var(--surface-2);
        }
        .btn-cancel {
            padding: 8px 18px; border-radius: var(--r);
            font-size: 13px; font-weight: 500; color: var(--text-2);
            background: var(--surface); border: 1px solid var(--border-md);
            text-decoration: none; transition: background .12s;
        }
        .btn-cancel:hover { background: var(--surface-2); color: var(--text); }
        .btn-save {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 20px; border-radius: var(--r);
            font-size: 13px; font-weight: 600; color: #fff;
            background: var(--accent); border: none; cursor: pointer;
            box-shadow: 0 2px 6px rgba(26,86,219,.25);
            transition: opacity .12s, transform .12s;
        }
        .btn-save:hover { opacity: .92; transform: translateY(-1px); }
        .btn-save svg { width: 14px; height: 14px; }

        /* ── Tips card (right) ── */
        .tips {}
        .tip {
            display: flex; gap: 12px; padding: 14px 16px;
            border-bottom: 1px solid var(--border); align-items: flex-start;
        }
        .tip:last-child { border-bottom: none; }
        .tip-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--surface-2); display: flex; align-items: center;
            justify-content: center; flex-shrink: 0; margin-top: 1px;
        }
        .tip-icon svg { width: 14px; height: 14px; color: var(--text-2); }
        .tip-title { font-size: 12.5px; font-weight: 600; color: var(--text); margin-bottom: 3px; }
        .tip-text { font-size: 12px; color: var(--text-3); line-height: 1.5; }
    </style>

    <div class="form-layout">
        {{-- Main form card --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                </div>
                <div>
                    <p class="card-title">Room Details</p>
                    <p class="card-subtitle">Fill in the information below. All rooms are single‑occupancy.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row2">
                        <!-- Room Number -->
                        <div class="field">
                            <label for="room_number" class="field-label">Room Number <span class="required">*</span></label>
                            <input id="room_number" type="text" name="room_number"
                                   value="{{ old('room_number') }}" placeholder="e.g. PS101"
                                   class="field-input" required autofocus>
                            @error('room_number')<p class="field-error">⚠️ {{ $message }}</p>@enderror
                        </div>
                        <!-- Image -->
                        <div class="field">
                            <label for="image" class="field-label">Room Image</label>
                            <input type="file" name="image" id="image"
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   class="field-input" style="padding: 8px;">
                            <p class="field-hint">Optional. Max 2MB, JPG/PNG/WEBP.</p>
                            @error('image')<p class="field-error">⚠️ {{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="row2">
                        <!-- Price -->
                        <div class="field">
                            <label for="price_per_month" class="field-label">Price per Month <span class="required">*</span></label>
                            <div class="price-wrapper">
                                <span class="price-symbol">₱</span>
                                <input id="price_per_month" type="number" step="0.01" min="0"
                                       name="price_per_month" value="{{ old('price_per_month') }}"
                                       placeholder="0.00" class="field-input" required>
                            </div>
                            @error('price_per_month')<p class="field-error">⚠️ {{ $message }}</p>@enderror
                        </div>
                        <!-- Status -->
                        <div class="field">
                            <label for="status" class="field-label">Initial Status <span class="required">*</span></label>
                            <select id="status" name="status" class="field-select" required>
                                <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            </select>
                            <p class="field-hint">You can always change this later.</p>
                            @error('status')<p class="field-error">⚠️ {{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('rooms.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Save Room
                    </button>
                </div>
            </form>
        </div>

        {{-- Tips card --}}
        <div class="card">
            <div class="card-header">
                <div>
                    <p class="card-title" style="margin:0;">Room Setup Tips</p>
                </div>
            </div>
            <div class="tips">
                <div class="tip">
                    <div class="tip-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 20l4-16m2 16l4-16"/></svg>
                    </div>
                    <div>
                        <div class="tip-title">Consistent numbering</div>
                        <div class="tip-text">Use a building‑prefix scheme (PS101, BE201) so rooms are easy to sort and find.</div>
                    </div>
                </div>
                <div class="tip">
                    <div class="tip-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/></svg>
                    </div>
                    <div>
                        <div class="tip-title">Fair pricing</div>
                        <div class="tip-text">Research local dormitory rates before setting the monthly price to stay competitive.</div>
                    </div>
                </div>
                <div class="tip">
                    <div class="tip-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="tip-title">Start as Available</div>
                        <div class="tip-text">Unless the room is already occupied, set the status to Available so students can request it.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>