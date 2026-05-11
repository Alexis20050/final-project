<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:10px;">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">Request a Room</h2>
        </div>
    </x-slot>

    <style>
        .back-btn {
            display: flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 7px;
            border: 1px solid var(--border-md); background: var(--surface);
            color: var(--text-2); text-decoration: none;
            transition: background 0.12s, transform 0.1s;
        }
        .back-btn:hover { background: var(--surface-2); transform: translateX(-2px); }

        .form-layout {
            display: grid; grid-template-columns: 1fr 250px;
            gap: 24px; align-items: start; max-width: 960px;
        }
        @media (max-width: 820px) { .form-layout { grid-template-columns: 1fr; } }

        .card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--r3); overflow: hidden;
        }
        .card-header {
            display: flex; align-items: center; gap: 11px;
            padding: 16px 20px; border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }
        .card-icon {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--accent-bg); display: flex;
            align-items: center; justify-content: center;
        }
        .card-icon svg { width: 15px; height: 15px; color: var(--accent); }
        .card-title { font-size: 14px; font-weight: 600; color: var(--text); margin:0 0 1px; }
        .card-subtitle { font-size: 11.5px; color: var(--text-3); margin:0; }

        .form-body { padding: 20px; display: flex; flex-direction: column; gap: 20px; }

        .field { display: flex; flex-direction: column; gap: 6px; }
        .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-2); }
        .field-label .required { color: var(--red); margin-left: 3px; }
        .field-hint { font-size: 11.5px; color: var(--text-3); margin-top: 4px; }

        .field-input, .field-select {
            width: 100%; padding: 10px 14px; background: var(--surface);
            border: 1px solid var(--border-md); border-radius: var(--r);
            font-size: 14px; color: var(--text); outline: none;
            transition: border 0.15s, box-shadow 0.15s;
        }
        .field-input:focus, .field-select:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(26,86,219,0.12);
        }
        .dark .field-input, .dark .field-select { background: var(--surface-2); }
        .field-error { font-size: 11.5px; color: var(--red); margin-top: 4px; display: flex; align-items: center; gap: 4px; }

        /* Controls row */
        .controls-row {
            display: flex; gap: 10px; align-items: center; flex-wrap: wrap;
            margin-bottom: 8px;
        }
        .controls-row select, .controls-row input {
            padding: 8px 12px; border-radius: var(--r);
            border: 1px solid var(--border-md);
            background: var(--surface); color: var(--text);
            font-size: 13px; outline: none;
        }
        .controls-row select { cursor: pointer; }
        .controls-row input { flex: 1; min-width: 160px; }

        /* Room grid */
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
        }
        .room-card {
            border: 2px solid var(--border);
            border-radius: var(--r2);
            overflow: hidden;
            cursor: pointer;
            background: var(--surface);
            transition: all 0.15s;
            position: relative;
        }
        .room-card:hover { border-color: var(--accent); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .room-card.selected {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(26,86,219,0.2);
        }
        .room-card.hidden { display: none; }

        .room-card img {
            width: 100%; height: 120px; object-fit: cover;
            border-bottom: 1px solid var(--border);
        }
        .room-card .no-img {
            width: 100%; height: 120px; background: var(--surface-2);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-3); border-bottom: 1px solid var(--border);
        }
        .room-card .card-info { padding: 10px 12px; }
        .room-number {
            font-weight: 700; font-family: var(--mono);
            color: var(--text);
        }
        .room-price {
            color: var(--accent-tx); font-weight: 600;
            margin-top: 4px; font-size: 14px;
        }
        .check-mark {
            position: absolute; top: 8px; right: 8px;
            width: 22px; height: 22px; border-radius: 50%;
            background: var(--accent); color: white;
            display: none; align-items: center; justify-content: center;
            font-size: 14px; font-weight: bold;
        }
        .room-card.selected .check-mark { display: flex; }

        .form-footer {
            padding: 14px 20px; border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: flex-end;
            gap: 8px; background: var(--surface-2);
        }
        .btn-cancel {
            padding: 8px 15px; border-radius: var(--r); font-size: 13px;
            font-weight: 500; color: var(--text-2); background: var(--surface);
            border: 1px solid var(--border-md); text-decoration: none;
        }
        .btn-cancel:hover { background: var(--surface-2); color: var(--text); }
        .btn-submit {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 18px; border-radius: var(--r); font-size: 13px;
            font-weight: 600; color: #fff; background: var(--accent);
            border: none; cursor: pointer; box-shadow: 0 1px 4px rgba(26,86,219,0.25);
            transition: opacity 0.12s, transform 0.1s;
        }
        .btn-submit:hover { opacity: 0.87; transform: translateY(-1px); }
        .btn-submit svg { width: 14px; height: 14px; }

        /* Minimal tips */
        .tip-box {
            padding: 16px;
            background: var(--surface-2);
            border-radius: var(--r);
            font-size: 12px;
            color: var(--text-3);
            line-height: 1.6;
        }
        .tip-box strong { color: var(--text-2); }
    </style>

    <div class="form-layout">
        <!-- Main form card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-9.5z"/></svg>
                </div>
                <div>
                    <p class="card-title">Room Request</p>
                    <p class="card-subtitle">Choose a room and suggest a move‑in date</p>
                </div>
            </div>

            <form method="POST" action="{{ route('applications.store') }}">
                @csrf
                <div class="form-body">
                    <input type="hidden" name="room_id" id="room_id" value="{{ old('room_id') }}">

                    <div class="field">
                        <div class="field-label">Select a Room <span class="required">*</span></div>
                        <p class="field-hint">Click on a room card to select it. You can sort by price or search by room number.</p>
                        @error('room_id')
                            <p class="field-error">⚠️ {{ $message }}</p>
                        @enderror

                        <!-- Sort & Search -->
                        <div class="controls-row">
                            <select id="priceSort" onchange="applyFilters()">
                                <option value="">Sort by price</option>
                                <option value="low">Price: Low → High</option>
                                <option value="high">Price: High → Low</option>
                            </select>
                            <input type="text" id="roomSearch" placeholder="Search room number…" oninput="applyFilters()">
                        </div>

                        <div class="room-grid" id="roomGrid">
                            @foreach($rooms as $room)
                                <div class="room-card {{ old('room_id') == $room->id ? 'selected' : '' }}"
                                     data-room-id="{{ $room->id }}"
                                     data-price="{{ $room->price_per_month }}"
                                     data-number="{{ $room->room_number }}"
                                     onclick="selectRoom(this, {{ $room->id }})">
                                    <div class="check-mark">✓</div>
                                    @if($room->image)
                                        <img src="{{ asset('storage/' . $room->image) }}" alt="Room {{ $room->room_number }}">
                                    @else
                                        <div class="no-img">
                                            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="card-info">
                                        <div class="room-number">{{ $room->room_number }}</div>
                                        <div class="room-price">₱{{ number_format($room->price_per_month, 0) }}/mo</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="field">
                        <label for="preferred_move_in" class="field-label">Preferred Move-in Date <span class="required">*</span></label>
                        <input type="date" name="preferred_move_in" id="preferred_move_in" class="field-input" required min="{{ date('Y-m-d') }}" value="{{ old('preferred_move_in') }}">
                        <p class="field-hint">The administrator will confirm the final date.</p>
                        @error('preferred_move_in')
                            <p class="field-error">⚠️ {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('dashboard') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-submit">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick tips (compact) -->
        <div class="tip-box">
            <strong>Tips</strong><br>
            • Use the <strong>price sorter</strong> to find rooms within your budget.<br>
            • Type a <strong>room number</strong> to quickly locate a specific room.<br>
            • Only <strong>one pending application</strong> is allowed at a time.<br>
            • An admin will review and approve / reject your request.
        </div>
    </div>

    <script>
        function selectRoom(card, roomId) {
            document.querySelectorAll('.room-card').forEach(el => el.classList.remove('selected'));
            card.classList.add('selected');
            document.getElementById('room_id').value = roomId;
        }

        function applyFilters() {
            const sortSelect = document.getElementById('priceSort');
            const searchInput = document.getElementById('roomSearch');
            const sortValue = sortSelect.value;
            const searchTerm = searchInput.value.toLowerCase().trim();
            const grid = document.getElementById('roomGrid');
            const cards = Array.from(grid.querySelectorAll('.room-card'));

            // Show/hide based on search
            cards.forEach(card => {
                const roomNumber = card.dataset.number.toLowerCase();
                card.classList.toggle('hidden', searchTerm !== '' && !roomNumber.includes(searchTerm));
            });

            // Sort visible cards
            if (sortValue !== '') {
                const visibleCards = cards.filter(c => !c.classList.contains('hidden'));
                const sorted = visibleCards.sort((a, b) => {
                    const priceA = parseFloat(a.dataset.price);
                    const priceB = parseFloat(b.dataset.price);
                    return sortValue === 'low' ? priceA - priceB : priceB - priceA;
                });
                sorted.forEach(card => grid.appendChild(card));
            }
        }
    </script>
</x-app-layout>