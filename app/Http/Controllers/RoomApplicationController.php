<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomApplication;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class RoomApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $query = RoomApplication::with('user', 'room')->latest();

            // ✅ Filter by status (e.g. ?status=pending)
            if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected', 'cancelled'])) {
                $query->where('status', $request->status);
            }

            $applications = $query->paginate(15)->appends($request->query());
            return view('applications.index', compact('applications'));
        }

        // Resident view – only own applications
        $applications = RoomApplication::where('user_id', $user->id)->latest()->paginate(10);
        return view('applications.my', compact('applications'));
    }

    // Keep the rest of the methods unchanged
    public function myApplications()
    {
        $applications = RoomApplication::where('user_id', Auth::id())->latest()->paginate(10);
        return view('applications.my', compact('applications'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        return view('applications.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'preferred_move_in' => 'required|date|after_or_equal:today',
        ]);

        $user = Auth::user();

        // Prevent multiple pending applications
        $existing = RoomApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        if ($existing) {
            return back()->withErrors(['msg' => 'You already have a pending application.']);
        }

        // Prevent request if user already has an active allocation
        $activeAllocation = Allocation::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();
        if ($activeAllocation) {
            return back()->withErrors(['msg' => 'You are already allocated to a room. You cannot request another room.']);
        }

        RoomApplication::create([
            'user_id' => $user->id,
            'room_id' => $request->room_id,
            'preferred_move_in' => $request->preferred_move_in,
            'status' => 'pending',
        ]);

        return redirect()->route('applications.my')->with('success', 'Application submitted.');
    }

    public function approve(RoomApplication $application)
    {
        // Quick polite check – stops most duplicate attempts
        $alreadyActive = Allocation::where('room_id', $application->room_id)
                            ->where('status', 'active')
                            ->exists();
        if ($alreadyActive) {
            return back()->withErrors(['msg' => 'This room already has an active resident. Cannot approve.']);
        }

        try {
            DB::transaction(function () use ($application) {
                // Approve the application
                $application->update(['status' => 'approved']);

                // Create the allocation
                Allocation::create([
                    'user_id'    => $application->user_id,
                    'room_id'    => $application->room_id,
                    'start_date' => $application->preferred_move_in,
                    'status'     => 'active',
                    'created_by' => Auth::id(),
                ]);

                // Mark the room as occupied
                $application->room->update(['status' => 'occupied']);

                // Auto‑reject all other pending requests for this room
                RoomApplication::where('room_id', $application->room_id)
                    ->where('status', 'pending')
                    ->where('id', '!=', $application->id)
                    ->update([
                        'status'      => 'rejected',
                        'admin_notes' => 'Room has been allocated to another student.',
                    ]);
            });
        } catch (QueryException $e) {
            // Catch the race condition – unique index violation
            if ($e->errorInfo[1] == 1062) { // MySQL Duplicate entry
                return back()->withErrors(['msg' => 'This room already has an active resident. Cannot approve another applicant.']);
            }
            throw $e;
        }

        return redirect()->route('applications.index')
                         ->with('success', 'Application approved and room allocated.');
    }

    public function reject(Request $request, RoomApplication $application)
    {
        $request->validate(['admin_notes' => 'nullable|string']);
        $application->update(['status' => 'rejected', 'admin_notes' => $request->admin_notes]);
        return redirect()->route('applications.index')->with('success', 'Application rejected.');
    }

    public function destroy(RoomApplication $application)
    {
        if ($application->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        $application->delete();
        return redirect()->route('applications.my')->with('success', 'Application cancelled.');
    }
}