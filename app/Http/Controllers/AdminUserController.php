<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Allocation;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // No constructor – middleware is applied in routes/web.php

    public function index(Request $request)
    {
        // Start query for resident users
        $query = User::where('role', 'resident');
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }
        
        // Load active allocation with room and paginate
        $users = $query->with(['activeAllocation' => function ($q) {
                $q->with('room');
            }])
            ->latest()
            ->paginate(10)
            ->appends(['search' => $request->search]); // preserve search term in pagination
        
        // If the request expects JSON (AJAX live search)
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'data' => $users->items(),
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'links' => $users->linkCollection()->toArray(),
            ]);
        }
        
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Only allow viewing of resident users
        if ($user->role !== 'resident') {
            abort(404);
        }

        // Load allocations (past and active) with rooms
        $user->load(['allocations' => function ($q) {
            $q->with('room')->latest();
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        // Prevent deleting admin or staff accounts from here
        if ($user->role !== 'resident') {
            return back()->with('error', 'You can only delete resident accounts.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}