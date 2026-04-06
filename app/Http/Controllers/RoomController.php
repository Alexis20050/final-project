<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number'      => 'required|unique:rooms',
            'type'             => 'required|in:single,double,dormitory',
            'capacity'         => 'required|integer|min:1',
            'price_per_month'  => 'required|numeric|min:0',
            'status'           => 'required|in:available,occupied,maintenance',
        ]);

        Room::create($validated);
        return redirect()->route('rooms.index')->with('success', 'Room created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number'      => 'required|unique:rooms,room_number,' . $room->id,
            'type'             => 'required|in:single,double,dormitory',
            'capacity'         => 'required|integer|min:1',
            'price_per_month'  => 'required|numeric|min:0',
            'status'           => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($validated);
        return redirect()->route('rooms.index')->with('success', 'Room updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted.');
    }
}