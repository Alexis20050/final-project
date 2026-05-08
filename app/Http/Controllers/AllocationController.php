<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class AllocationController extends Controller
{
    public function index()
    {
        $allocations = Allocation::with('user', 'room')->latest()->paginate(20);
        return view('allocations.index', compact('allocations'));
    }

    public function create()
    {
        $students = User::where('role', 'resident')->get();
        $rooms = Room::where('status', 'available')->get();
        return view('allocations.create', compact('students', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'room_id'    => 'required|exists:rooms,id',
            'start_date' => 'required|date',
        ]);

        // 1. Prevent double allocation for the same user
        $userActive = Allocation::where('user_id', $validated['user_id'])
                        ->where('status', 'active')
                        ->first();
        if ($userActive) {
            return back()->withErrors(['msg' => 'Student already has an active allocation.']);
        }

        // 2. Check if room is already occupied by another active resident
        $roomActive = Allocation::where('room_id', $validated['room_id'])
                        ->where('status', 'active')
                        ->exists();
        if ($roomActive) {
            return back()->withErrors(['msg' => 'This room already has an active resident.']);
        }

        $room = Room::find($validated['room_id']);
        if ($room->status !== 'available') {
            return back()->withErrors(['msg' => 'Room is not available.']);
        }

        try {
            DB::transaction(function () use ($validated, $room) {
                Allocation::create([
                    'user_id'    => $validated['user_id'],
                    'room_id'    => $validated['room_id'],
                    'start_date' => $validated['start_date'],
                    'status'     => 'active',
                    'created_by' => auth()->id(),
                ]);

                $room->update(['status' => 'occupied']);
            });
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->withErrors(['msg' => 'This room already has an active resident. Cannot allocate another student.']);
            }
            throw $e;
        }

        return redirect()->route('allocations.index')
                         ->with('success', 'Allocation created.');
    }

    /**
     * Admin ends an allocation (evicts a student from a room).
     */
    public function end(Allocation $allocation)
    {
        $allocation->update(['end_date' => now(), 'status' => 'completed']);
        $allocation->room->update(['status' => 'available']);
        return redirect()->route('allocations.index')->with('success', 'Allocation ended.');
    }

    // ❌ The 'leave' method has been removed – only admins can remove residents.
}