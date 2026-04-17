<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Room::query();

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

        // Students (residents) cannot view rooms that are not available
        if ($user && $user->isResident() && $room->status !== 'available') {
            abort(404, 'Room not found.');
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

    public function destroy(Room $room)
    {
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted.');
    }
}