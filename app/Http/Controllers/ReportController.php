<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Allocation;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function occupancy()
    {
        $totalRooms = Room::count();
        $available = Room::where('status', 'available')->count();
        $occupied = Room::where('status', 'occupied')->count();
        $maintenance = Room::where('status', 'maintenance')->count();

        $byBuilding = Room::with('building')
            ->selectRaw('building_id, count(*) as total, sum(case when status="occupied" then 1 else 0 end) as occupied')
            ->groupBy('building_id')
            ->get();

        return view('reports.occupancy', compact('totalRooms', 'available', 'occupied', 'maintenance', 'byBuilding'));
    }

    public function maintenance()
    {
        $pending = MaintenanceRequest::where('status', 'pending')->count();
        $inProgress = MaintenanceRequest::where('status', 'in_progress')->count();
        $resolved = MaintenanceRequest::where('status', 'resolved')->count();
        $byPriority = MaintenanceRequest::selectRaw('priority, count(*) as count')->groupBy('priority')->get();
        $recent = MaintenanceRequest::with('user', 'room')->latest()->take(10)->get();

        return view('reports.maintenance', compact('pending', 'inProgress', 'resolved', 'byPriority', 'recent'));
    }
}