<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomApplicationController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (no authentication required)
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');
Route::view('/about', 'about')->name('about');

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes (require login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== ROOMS ====================
    // Index (list)
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

    // Admin-only actions (static routes first)
    Route::middleware(['admin'])->group(function () {
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        // Removed destroy route – replaced by archive/restore
        Route::patch('/rooms/{room}/archive', [RoomController::class, 'archive'])->name('rooms.archive');
        Route::patch('/rooms/{room}/restore', [RoomController::class, 'restore'])->name('rooms.restore');
    });

    // Student direct request (POST)
    Route::post('/rooms/{room}/request', [RoomController::class, 'requestRoom'])->name('rooms.request');

    // Show route – MUST be LAST to avoid catching 'create' or 'edit' as {room}
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

    // ==================== BUILDINGS ====================
    Route::resource('buildings', BuildingController::class)->middleware('admin');

    // ==================== ROOM APPLICATIONS ====================
    Route::resource('applications', RoomApplicationController::class)->except(['edit', 'update']);
    Route::get('/my-applications', [RoomApplicationController::class, 'myApplications'])->name('applications.my');
    Route::patch('/applications/{application}/approve', [RoomApplicationController::class, 'approve'])->name('applications.approve')->middleware('admin');
    Route::patch('/applications/{application}/reject', [RoomApplicationController::class, 'reject'])->name('applications.reject')->middleware('admin');

    // ==================== ALLOCATIONS ====================
    Route::resource('allocations', AllocationController::class)->middleware('admin');
    Route::patch('/allocations/{allocation}/leave', [AllocationController::class, 'leave'])->name('allocations.leave');
    Route::post('/allocations/{allocation}/end', [AllocationController::class, 'end'])->name('allocations.end')->middleware('admin');

    // ==================== MAINTENANCE REQUESTS ====================
    Route::resource('maintenance-requests', MaintenanceRequestController::class);
    Route::patch('/maintenance-requests/{maintenanceRequest}/assign', [MaintenanceRequestController::class, 'assign'])->name('maintenance-requests.assign')->middleware('admin');
    Route::patch('/maintenance-requests/{maintenanceRequest}/status', [MaintenanceRequestController::class, 'updateStatus'])->name('maintenance-requests.update-status');

    // ==================== REPORTS ====================
    Route::prefix('reports')->name('reports.')->middleware('admin')->group(function () {
        Route::get('/occupancy', [ReportController::class, 'occupancy'])->name('occupancy');
        Route::get('/maintenance', [ReportController::class, 'maintenance'])->name('maintenance');
    });
});

/*
|--------------------------------------------------------------------------
| Admin-Only Routes (separate prefix for cleaner separation)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class)->only(['index', 'show', 'destroy']);
});