<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomApplication;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Room::query();

        // Admin can filter archived rooms (if ?archived=1)
        if ($user && $user->isAdmin() && $request->boolean('archived')) {
            $query->where('archived', true);
        } elseif (!$user || !$user->isAdmin()) {
            // Non‑admin users never see archived rooms
            $query->where('archived', false);
        }

        // Apply status filter if provided (admin/staff can filter any status)
        if ($request->filled('status') && in_array($request->status, ['available', 'occupied', 'maintenance'])) {
            $query->where('status', $request->status);
        }

        // Students (residents) can only see available rooms
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
            'type'             => 'required|in:single,double,dormitory',
            'capacity'         => 'required|integer|min:1',
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

        // Block non‑admin users from seeing archived rooms
        if (!$user->isAdmin() && $room->archived) {
            abort(404);
        }

        // Students (residents) can only view available rooms OR their own allocated room
        if ($user && $user->isResident()) {
            // Get the student's active allocation (if any)
            $activeAllocation = Allocation::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();
            $isTheirRoom = $activeAllocation && $activeAllocation->room_id === $room->id;

            // Allow if it's their own room OR the room is available
            if (!$isTheirRoom && $room->status !== 'available') {
                abort(404, 'Room not found.');
            }
        }

        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number'      => 'required|unique:rooms,room_number,' . $room->id,
            'type'             => 'required|in:single,double,dormitory',
            'capacity'         => 'required|integer|min:1',
            'price_per_month'  => 'required|numeric|min:0',
            'status'           => 'required|in:available,occupied,maintenance',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

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
     * Archive a room (soft hide – hidden from students/staff).
     */
    public function archive(Room $room)
    {
        $room->update(['archived' => true]);
        return redirect()->route('rooms.index')->with('success', 'Room archived.');
    }

    /**
     * Restore an archived room (make it visible again).
     */
    public function restore(Room $room)
    {
        $room->update(['archived' => false]);
        return redirect()->route('rooms.index')->with('success', 'Room restored.');
    }

    /**
     * Handle a direct room request from a student.
     */
    public function requestRoom(Room $room)
    {
        $user = auth()->user();

        // Only residents can request
        if (!$user->isResident()) {
            abort(403, 'Only students can request rooms.');
        }

        // Only available rooms can be requested
        if ($room->status !== 'available') {
            return back()->with('error', 'This room is not available.');
        }

        // Check if user already has a pending application
        $existing = RoomApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        if ($existing) {
            return back()->with('error', 'You already have a pending room request. Please wait for it to be processed.');
        }

        // Create the application
        RoomApplication::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'preferred_move_in' => now()->addDays(7)->toDateString(),
            'status' => 'pending',
        ]);

        return redirect()->route('applications.my')->with('success', 'Room request submitted. An administrator will review it.');
    }
}