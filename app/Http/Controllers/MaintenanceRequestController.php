<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\MaintenanceRequest;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            $requests = MaintenanceRequest::with('user', 'room', 'assignedStaff')->latest()->paginate(15);
            $staffList = User::where('role', 'staff')->get();
            return view('maintenance.index', compact('requests', 'staffList'));
        } elseif ($user->isStaff()) {
            $requests = MaintenanceRequest::where('assigned_to', $user->id)->orWhereNull('assigned_to')->latest()->paginate(15);
            return view('maintenance.index', compact('requests'));
        } else {
            $requests = MaintenanceRequest::where('user_id', $user->id)->latest()->paginate(10);
            return view('maintenance.index', compact('requests'));
        }
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->isResident()) {
            $rooms = Room::whereHas('allocations', function ($q) use ($user) {
                $q->where('user_id', $user->id)->where('status', 'active');
            })->get();
        } else {
            $rooms = collect();
        }
        return view('maintenance.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('maintenance', 'public');
        }

        $maintenanceRequest = MaintenanceRequest::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'pending',
            'image' => $imagePath,
        ]);

        // Update room status to 'maintenance'
        $room = Room::find($request->room_id);
        if ($room && $room->status !== 'maintenance') {
            $room->status = 'maintenance';
            $room->save(); // use save() to be explicit
            Log::info("Room {$room->id} status changed to maintenance due to request #{$maintenanceRequest->id}");
        } else {
            Log::warning("Room {$room->id} status was already maintenance or not found.");
        }

        return redirect()->route('maintenance-requests.index')->with('success', 'Maintenance request submitted.');
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('view', $maintenanceRequest);
        return view('maintenance.show', compact('maintenanceRequest'));
    }

    public function assign(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $request->validate(['assigned_to' => 'required|exists:users,id']);
        $maintenanceRequest->update(['assigned_to' => $request->assigned_to]);
        return redirect()->route('maintenance-requests.index')->with('success', 'Request assigned.');
    }

    public function updateStatus(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $request->validate(['status' => 'required|in:pending,in_progress,resolved,cancelled']);
        $oldStatus = $maintenanceRequest->status;
        $newStatus = $request->status;
        
        $data = ['status' => $newStatus];
        if ($newStatus === 'resolved') {
            $data['resolved_at'] = now();
        }
        $maintenanceRequest->update($data);

        // Update room status based on the change
        $room = $maintenanceRequest->room;
        if ($newStatus === 'resolved' && $oldStatus !== 'resolved') {
            $activeAllocation = Allocation::where('room_id', $room->id)
                ->where('status', 'active')
                ->exists();
            $newRoomStatus = $activeAllocation ? 'occupied' : 'available';
            $room->update(['status' => $newRoomStatus]);
            Log::info("Room {$room->id} status changed to {$newRoomStatus} after resolving request #{$maintenanceRequest->id}");
        } elseif ($newStatus === 'in_progress' && $oldStatus === 'pending') {
            if ($room->status !== 'maintenance') {
                $room->update(['status' => 'maintenance']);
                Log::info("Room {$room->id} status set to maintenance (in_progress) for request #{$maintenanceRequest->id}");
            }
        }

        return redirect()->route('maintenance-requests.index')->with('success', 'Status updated.');
    }
}