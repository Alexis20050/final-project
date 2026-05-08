<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomApplication;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Room::query();

        // Admin: archived filter handling
        if ($user && $user->isAdmin()) {
            if ($request->boolean('archived')) {
                $query->where('archived', true);
            } elseif (!$request->filled('status')) {
                $query->where('archived', false);
            }
        } else {
            $query->where('archived', false);
        }

        // Apply status filter (including 'archived')
        if ($request->filled('status') && in_array($request->status, ['available', 'occupied', 'maintenance', 'archived'])) {
            $query->where('status', $request->status);
        }

        // Students see only available rooms
        if ($user && $user->isResident()) {
            $query->where('status', 'available');
        }

        $rooms = $query->latest()->paginate(12);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number'      => 'required|unique:rooms',
            'price_per_month'  => 'required|numeric|min:0',
            'status'           => 'required|in:available,occupied,maintenance',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($validated);
        return redirect()->route('rooms.index')->with('success', 'Room created.');
    }

    public function show(Room $room)
    {
        $user = auth()->user();

        if (!$user->isAdmin() && $room->archived) {
            abort(404);
        }

        // ✅ Load the active allocation (with resident) for this room
        $activeAllocation = Allocation::where('room_id', $room->id)
                              ->where('status', 'active')
                              ->with('user')
                              ->first();

        // Resident visibility logic
        if ($user && $user->isResident()) {
            $myActive = Allocation::where('user_id', $user->id)
                        ->where('status', 'active')
                        ->first();
            $isTheirRoom = $myActive && $myActive->room_id === $room->id;

            if (!$isTheirRoom && $room->status !== 'available') {
                abort(404, 'Room not found.');
            }
        }

        return view('rooms.show', compact('room', 'activeAllocation'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number'      => 'required|unique:rooms,room_number,' . $room->id,
            'price_per_month'  => 'required|numeric|min:0',
            'status'           => 'required|in:available,occupied,maintenance',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Prevent setting to 'available' if there's an active resident
        if ($validated['status'] === 'available') {
            $active = Allocation::where('room_id', $room->id)
                        ->where('status', 'active')
                        ->exists();
            if ($active) {
                return back()->withErrors([
                    'status' => 'Cannot set room to available while a resident is allocated. End the allocation first.'
                ]);
            }
        }

        // Image handling
        if ($request->hasFile('image')) {
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $validated['image'] = $request->file('image')->store('rooms', 'public');
        } else {
            $validated['image'] = $room->image;
        }

        $room->update($validated);
        return redirect()->route('rooms.index')->with('success', 'Room updated.');
    }

    /**
     * Archive a room – automatically ends any active allocation.
     */
    public function archive(Room $room)
    {
        $activeAllocation = Allocation::where('room_id', $room->id)
                              ->where('status', 'active')
                              ->first();
        if ($activeAllocation) {
            $activeAllocation->update([
                'end_date' => now(),
                'status'   => 'completed',
            ]);
        }

        $room->update([
            'archived' => true,
            'status'   => 'archived',
        ]);
        return redirect()->route('rooms.index')->with('success', 'Room archived.');
    }

    /**
     * Restore an archived room – sets status correctly based on current allocations.
     */
    public function restore(Room $room)
    {
        $hasActive = Allocation::where('room_id', $room->id)
                        ->where('status', 'active')
                        ->exists();

        $room->update([
            'archived' => false,
            'status'   => $hasActive ? 'occupied' : 'available',
        ]);
        return redirect()->route('rooms.index')->with('success', 'Room restored.');
    }

    /**
     * Remove the current resident from a room (admin eviction).
     */
    public function removeResident(Room $room)
    {
        $activeAllocation = Allocation::where('room_id', $room->id)
                              ->where('status', 'active')
                              ->first();

        if (!$activeAllocation) {
            return back()->with('error', 'No active resident in this room.');
        }

        DB::transaction(function () use ($room, $activeAllocation) {
            $activeAllocation->update([
                'end_date' => now(),
                'status'   => 'completed',
            ]);
            $room->update(['status' => 'available']);
        });

        return redirect()->route('rooms.index')
                         ->with('success', 'Resident has been removed from the room.');
    }

    public function requestRoom(Room $room)
    {
        $user = auth()->user();

        if (!$user->isResident()) {
            abort(403, 'Only students can request rooms.');
        }

        if ($room->status !== 'available') {
            return back()->with('error', 'This room is not available.');
        }

        $existing = RoomApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        if ($existing) {
            return back()->with('error', 'You already have a pending room request.');
        }

        $activeAllocation = Allocation::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();
        if ($activeAllocation) {
            return back()->with('error', 'You are already allocated to a room. You cannot request another room.');
        }

        RoomApplication::create([
            'user_id'              => $user->id,
            'room_id'              => $room->id,
            'preferred_move_in'    => now()->addDays(7)->toDateString(),
            'status'               => 'pending',
        ]);

        return redirect()->route('applications.my')
                         ->with('success', 'Room request submitted. An administrator will review it.');
    }
}