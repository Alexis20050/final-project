<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomApplication;
use App\Models\Allocation;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Use same variable names as your old dashboard.blade.php
            $total = Room::count();
            $available = Room::where('status', 'available')->count();
            $occupied = Room::where('status', 'occupied')->count();
            $maintenance = Room::where('status', 'maintenance')->count();
            $rate = $total > 0 ? round(($occupied / $total) * 100) : 0;

            $pendingApplications = RoomApplication::where('status', 'pending')->count();
            $pendingMaintenance = MaintenanceRequest::where('status', 'pending')->count();
            $recentAllocations = Allocation::with('user', 'room')->latest()->take(5)->get();

            return view('dashboard.admin', compact(
                'total', 'available', 'occupied', 'maintenance', 'rate',
                'pendingApplications', 'pendingMaintenance', 'recentAllocations'
            ));
        }

       // Inside DashboardController, replace the staff block with:

if ($user->isStaff()) {
    // Eager load room relationship, paginate (15 per page)
    $assignedRequests = MaintenanceRequest::with('room')
        ->where(function ($query) use ($user) {
            $query->where('assigned_to', $user->id)
                  ->orWhereNull('assigned_to');
        })
        ->where('status', '!=', 'resolved')
        ->paginate(15); // paginate instead of get()

    // Compute stats in controller
    $pendingCount = $assignedRequests->where('status', 'pending')->count();
    $inProgressCount = $assignedRequests->where('status', 'in_progress')->count();
    $unassignedCount = $assignedRequests->whereNull('assigned_to')->count();
    $myAssignedCount = $assignedRequests->where('assigned_to', $user->id)->count();
    $resolvedCount = MaintenanceRequest::where('assigned_to', $user->id)
        ->where('status', 'resolved')
        ->count();

    return view('dashboard.staff', compact(
        'assignedRequests', 'resolvedCount', 'pendingCount',
        'inProgressCount', 'unassignedCount', 'myAssignedCount'
    ));
}
        // Student dashboard
        $activeAllocation = Allocation::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();
        $pendingApplication = RoomApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        $recentRequests = MaintenanceRequest::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Additional stats for student (optional, but useful)
        $totalMaintenance = MaintenanceRequest::where('user_id', $user->id)->count();
        $pendingMaintenance = MaintenanceRequest::where('user_id', $user->id)
            ->where('status', 'pending')->count();
        $resolvedMaintenance = MaintenanceRequest::where('user_id', $user->id)
            ->where('status', 'resolved')->count();
        $pastAllocations = Allocation::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('end_date', 'desc')
            ->take(3)->get();

        return view('dashboard.student', compact(
            'activeAllocation', 'pendingApplication', 'recentRequests',
            'totalMaintenance', 'pendingMaintenance', 'resolvedMaintenance',
            'pastAllocations'
        ));
    }
}