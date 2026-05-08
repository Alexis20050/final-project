{{-- resources/views/allocations/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('allocations.index') }}" style="display:flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:7px; border:1px solid var(--border-md); background:var(--surface); color:var(--text-2); text-decoration:none;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="page-header-title">Manual Allocation</h2>
        </div>
    </x-slot>

    {{-- 🔴 Error alert --}}
    @if($errors->any())
        <div style="background:var(--red-bg); color:var(--red); padding:12px 16px; border-radius:var(--r); margin-bottom:16px; font-size:14px;">
            @foreach($errors->all() as $error)
                <p style="margin:0;">⚠️ {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <style>
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r2);
            padding: 24px;
            max-width: 600px;
            margin: 0 auto;
        }
        .field {
            margin-bottom: 16px;
        }
        .field label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }
        .field select, .field input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-md);
            border-radius: var(--r);
            background: var(--surface);
            color: var(--text);
        }
        .btn-submit {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: var(--r);
            font-weight: 500;
            cursor: pointer;
        }
        .btn-submit:hover {
            opacity: 0.9;
        }
    </style>

    <div class="form-card">
        <form method="POST" action="{{ route('allocations.store') }}">
            @csrf

            <div class="field">
                <label for="user_id">Student</label>
                <select name="user_id" id="user_id" required>
                    <option value="">Choose a student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="room_id">Room</label>
                <select name="room_id" id="room_id" required>
                    <option value="">Choose a room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            Room {{ $room->room_number }} – ₱{{ number_format($room->price_per_month, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" required value="{{ old('start_date') }}">
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-submit">Create Allocation</button>
            </div>
        </form>
    </div>
</x-app-layout>