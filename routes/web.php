<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes (no login required)
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/about', 'about')->name('about');

// Breeze Authentication Routes (login, register, logout, password reset)
require __DIR__.'/auth.php';

// Authenticated Routes (require login)
Route::middleware(['auth'])->group(function () {

    // Dashboard (after login)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROOMS CRUD - Full resource controller
    // Access control (admin only for create/edit/update/delete) is handled inside RoomController
    Route::resource('rooms', RoomController::class);
});