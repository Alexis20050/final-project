<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:10px;">
            <a href="{{ route('maintenance-requests.index') }}" class="back-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">Report a Maintenance Issue</h2>
        </div>
    </x-slot>

    <style>
        .back-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1px solid var(--border-md);
            background: var(--surface);
            color: var(--text-2);
            text-decoration: none;
            transition: background 0.12s, transform 0.1s;
        }
        .back-btn:hover {
            background: var(--surface-2);
            transform: translateX(-2px);
        }

        .form-layout {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 20px;
            align-items: start;
            max-width: 880px;
        }
        @media (max-width: 820px) {
            .form-layout {
                grid-template-columns: 1fr;
            }
        }

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
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }
        .card-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--accent-bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-icon svg {
            width: 15px;
            height: 15px;
            color: var(--accent);
        }
        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin: 0 0 1px;
        }
        .card-subtitle {
            font-size: 11.5px;
            color: var(--text-3);
            margin: 0;
        }

        .form-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .field-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-2);
        }
        .field-label .required {
            color: var(--red);
            margin-left: 3px;
        }
        .field-hint {
            font-size: 11.5px;
            color: var(--text-3);
            margin-top: 4px;
        }

        .field-input, .field-select, .field-textarea {
            width: 100%;
            padding: 8px 12px;
            background: var(--surface);
            border: 1px solid var(--border-md);
            border-radius: var(--r);
            font-size: 13.5px;
            color: var(--text);
            outline: none;
            transition: border 0.15s, box-shadow 0.15s;
        }
        .field-input:focus, .field-select:focus, .field-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }
        .dark .field-input, .dark .field-select, .dark .field-textarea {
            background: var(--surface-2);
        }
        .field-textarea {
            resize: vertical;
            min-height: 100px;
        }
        .field-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }

        .field-error {
            font-size: 11.5px;
            color: var(--red);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            background: var(--surface-2);
        }
        .btn-cancel {
            padding: 8px 15px;
            border-radius: var(--r);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-2);
            background: var(--surface);
            border: 1px solid var(--border-md);
            text-decoration: none;
            transition: background 0.12s;
        }
        .btn-cancel:hover {
            background: var(--surface-2);
            color: var(--text);
        }
        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            border-radius: var(--r);
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--accent);
            border: none;
            cursor: pointer;
            transition: opacity 0.12s, transform 0.1s;
            box-shadow: 0 1px 4px rgba(26,86,219,0.25);
        }
        .btn-submit:hover {
            opacity: 0.87;
            transform: translateY(-1px);
        }
        .btn-submit svg {
            width: 14px;
            height: 14px;
        }

        /* Tips card */
        .tips-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .tip-item {
            display: flex;
            gap: 10px;
            padding: 13px 16px;
            border-bottom: 1px solid var(--border);
            align-items: flex-start;
        }
        .tip-item:last-child {
            border-bottom: none;
        }
        .tip-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--surface-2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .tip-icon svg {
            width: 13px;
            height: 13px;
            color: var(--text-2);
        }
        .tip-title {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 2px;
        }
        .tip-desc {
            font-size: 12px;
            color: var(--text-3);
            line-height: 1.55;
        }
    </style>

    <div class="form-layout">
        <!-- Main form card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="card-title">Maintenance Request</p>
                    <p class="card-subtitle">Report an issue in your room</p>
                </div>
            </div>

            <form method="POST" action="{{ route('maintenance-requests.store') }}">
                @csrf
                <div class="form-body">
                    <div class="field">
                        <label for="room_id" class="field-label">Room <span class="required">*</span></label>
                        <select name="room_id" id="room_id" class="field-select" required>
                            <option value="">Select a room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">Room {{ $room->room_number }} ({{ ucfirst($room->type) }})</option>
                            @endforeach
                        </select>
                        <p class="field-hint">Select the room where the issue occurred.</p>
                        @error('room_id')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="title" class="field-label">Title <span class="required">*</span></label>
                        <input type="text" name="title" id="title" class="field-input" placeholder="e.g., Broken AC, Leaking faucet" required>
                        <p class="field-hint">A short, descriptive title for the issue.</p>
                        @error('title')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="description" class="field-label">Description <span class="required">*</span></label>
                        <textarea name="description" id="description" class="field-textarea" placeholder="Describe the issue in detail" required></textarea>
                        <p class="field-hint">Provide as much detail as possible to help staff resolve it quickly.</p>
                        @error('description')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="priority" class="field-label">Priority <span class="required">*</span></label>
                        <select name="priority" id="priority" class="field-select" required>
                            <option value="low">Low – Non‑urgent (cosmetic, minor)</option>
                            <option value="medium">Medium – Needs attention soon (affects comfort)</option>
                            <option value="high">High – Urgent / Emergency (safety, major damage)</option>
                        </select>
                        <p class="field-hint">Select the appropriate priority level.</p>
                        @error('priority')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('maintenance-requests.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-submit">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips card -->
        <div class="card">
            <div class="card-header" style="border-bottom: 1px solid var(--border);">
                <div>
                    <p class="card-title" style="margin: 0;">Reporting Tips</p>
                    <p class="card-subtitle" style="margin: 0;">How to get faster help</p>
                </div>
            </div>
            <ul class="tips-list">
                <li class="tip-item">
                    <div class="tip-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <div class="tip-title">Be specific</div>
                        <div class="tip-desc">Mention exact location (e.g., "bathroom sink") to help staff locate the issue.</div>
                    </div>
                </li>
                <li class="tip-item">
                    <div class="tip-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="tip-title">Add photos (if needed)</div>
                        <div class="tip-desc">You can attach images to your request – they help staff understand the problem.</div>
                    </div>
                </li>
                <li class="tip-item">
                    <div class="tip-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="tip-title">Set correct priority</div>
                        <div class="tip-desc">Urgent issues (e.g., no hot water, gas leak) should be marked "High".</div>
                    </div>
                </li>
                <li class="tip-item">
                    <div class="tip-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="tip-title">Track your request</div>
                        <div class="tip-desc">You can check the status of your requests on the maintenance index page.</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>