<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomApplication;
use App\Models\Allocation;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // -------------------- ADMIN DASHBOARD --------------------
        if ($user->isAdmin()) {
            $total = Room::count();
            $available = Room::where('status', 'available')->count();
            $occupied = Room::where('status', 'occupied')->count();
            $maintenance = Room::where('status', 'maintenance')->count();
            $rate = $total > 0 ? round(($occupied / $total) * 100) : 0;

            // ✅ Total Residents
            $totalResidents = User::where('role', 'resident')->count();

            $pendingApplications = RoomApplication::where('status', 'pending')->count();
            $pendingMaintenance = MaintenanceRequest::where('status', 'pending')->count();
            $recentAllocations = Allocation::with('user', 'room')->latest()->take(5)->get();

            return view('dashboard.admin', compact(
                'total', 'available', 'occupied', 'maintenance', 'rate',
                'pendingApplications', 'pendingMaintenance', 'recentAllocations',
                'totalResidents'
            ));
        }

        // -------------------- STAFF DASHBOARD --------------------
        if ($user->isStaff()) {
            $assignedRequests = MaintenanceRequest::with('room')
                ->where(function ($query) use ($user) {
                    $query->where('assigned_to', $user->id)
                          ->orWhereNull('assigned_to');
                })
                ->where('status', '!=', 'resolved')
                ->paginate(15);

            $pendingCount = MaintenanceRequest::where(function ($q) use ($user) {
                    $q->where('assigned_to', $user->id)->orWhereNull('assigned_to');
                })->where('status', 'pending')->count();

            $unassignedCount = MaintenanceRequest::whereNull('assigned_to')
                ->where('status', '!=', 'resolved')
                ->count();

            $myAssignedCount = MaintenanceRequest::where('assigned_to', $user->id)
                ->where('status', '!=', 'resolved')
                ->count();

            $resolvedCount = MaintenanceRequest::where('assigned_to', $user->id)
                ->where('status', 'resolved')
                ->count();

            return view('dashboard.staff', compact(
                'assignedRequests', 'resolvedCount', 'pendingCount',
                'unassignedCount', 'myAssignedCount'
            ));
        }

        // -------------------- STUDENT DASHBOARD --------------------
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

        $totalMaintenance = MaintenanceRequest::where('user_id', $user->id)->count();
        $pendingMaintenance = MaintenanceRequest::where('user_id', $user->id)
            ->where('status', 'pending')->count();
        $resolvedMaintenance = MaintenanceRequest::where('user_id', $user->id)
            ->where('status', 'resolved')->count();

        $pastAllocations = Allocation::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('end_date', 'desc')
            ->take(3)
            ->get();

        return view('dashboard.student', compact(
            'activeAllocation', 'pendingApplication', 'recentRequests',
            'totalMaintenance', 'pendingMaintenance', 'resolvedMaintenance',
            'pastAllocations'
        ));
    }
}