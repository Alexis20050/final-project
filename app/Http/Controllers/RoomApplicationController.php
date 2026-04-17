<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomApplication;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomApplicationController extends Controller
{
    // No constructor needed – middleware is applied in routes

    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $applications = RoomApplication::with('user', 'room')->latest()->paginate(15);
            return view('applications.index', compact('applications'));
        }
        $applications = RoomApplication::where('user_id', $user->id)->latest()->paginate(10);
        return view('applications.my', compact('applications'));
    }

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

        $existing = RoomApplication::where('user_id', Auth::id())->where('status', 'pending')->first();
        if ($existing) {
            return back()->withErrors(['msg' => 'You already have a pending application.']);
        }

        RoomApplication::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'preferred_move_in' => $request->preferred_move_in,
            'status' => 'pending',
        ]);

        return redirect()->route('applications.my')->with('success', 'Application submitted.');
    }

    public function approve(RoomApplication $application)
    {
        $application->update(['status' => 'approved']);

        Allocation::create([
            'user_id' => $application->user_id,
            'room_id' => $application->room_id,
            'start_date' => $application->preferred_move_in,
            'status' => 'active',
            'created_by' => Auth::id(),
        ]);

        $application->room->update(['status' => 'occupied']);

        return redirect()->route('applications.index')->with('success', 'Application approved and room allocated.');
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