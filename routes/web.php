<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomApplicationController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');
Route::view('/about', 'about')->name('about');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Dashboard (now using controller for role‑specific views)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== ROOMS ====================
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::middleware(['admin'])->group(function () {
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    });
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

    // ==================== BUILDINGS ====================
    Route::resource('buildings', BuildingController::class)->middleware('admin');

    // ==================== ROOM APPLICATIONS ====================
    Route::resource('applications', RoomApplicationController::class)->except(['edit', 'update']);
    Route::patch('/applications/{application}/approve', [RoomApplicationController::class, 'approve'])->name('applications.approve')->middleware('admin');
    Route::patch('/applications/{application}/reject', [RoomApplicationController::class, 'reject'])->name('applications.reject')->middleware('admin');
    // Student view of own applications
    Route::get('/my-applications', [RoomApplicationController::class, 'myApplications'])->name('applications.my');

    // ==================== ALLOCATIONS ====================
    Route::resource('allocations', AllocationController::class)->middleware('admin');
    Route::post('/allocations/{allocation}/end', [AllocationController::class, 'end'])->name('allocations.end')->middleware('admin');

    // ==================== MAINTENANCE REQUESTS ====================
    Route::resource('maintenance-requests', MaintenanceRequestController::class);
    Route::patch('/maintenance-requests/{maintenanceRequest}/assign', [MaintenanceRequestController::class, 'assign'])->name('maintenance-requests.assign')->middleware('admin');
    Route::patch('/maintenance-requests/{maintenanceRequest}/status', [MaintenanceRequestController::class, 'updateStatus'])->name('maintenance-requests.update-status');

    // ==================== REPORTS ====================
    Route::get('/reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy')->middleware('admin');
    Route::get('/reports/maintenance', [ReportController::class, 'maintenance'])->name('reports.maintenance')->middleware('admin');
});