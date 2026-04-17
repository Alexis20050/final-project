<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Allocation;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

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
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
        ]);

        $active = Allocation::where('user_id', $validated['user_id'])->where('status', 'active')->first();
        if ($active) {
            return back()->withErrors(['msg' => 'Student already has an active allocation.']);
        }

        $room = Room::find($validated['room_id']);
        if ($room->status !== 'available') {
            return back()->withErrors(['msg' => 'Room is not available.']);
        }

        $validated['status'] = 'active';
        $validated['created_by'] = auth()->id();
        Allocation::create($validated);

        $room->update(['status' => 'occupied']);

        return redirect()->route('allocations.index')->with('success', 'Allocation created.');
    }

    public function end(Allocation $allocation)
    {
        $allocation->update(['end_date' => now(), 'status' => 'completed']);
        $allocation->room->update(['status' => 'available']);
        return redirect()->route('allocations.index')->with('success', 'Allocation ended.');
    }
}