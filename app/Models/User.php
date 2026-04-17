<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'student_id', 'phone',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role'              => 'string',
    ];

    // ── Role helpers ──────────────────────────────────────────
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isStaff(): bool    { return $this->role === 'staff'; }
    public function isResident(): bool { return $this->role === 'resident'; }

    // ── Relationships ─────────────────────────────────────────
    public function roomApplications()
    {
        return $this->hasMany(RoomApplication::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }

    public function activeAllocation()
    {
        return $this->hasOne(Allocation::class)->where('status', 'active');
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function assignedMaintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_to');
    }

    public function createdAllocations()
    {
        return $this->hasMany(Allocation::class, 'created_by');
    }

    // ── Convenience helpers ───────────────────────────────────
    /**
     * Get the room the user is currently allocated to (if any).
     */
    public function currentRoom()
    {
        return $this->activeAllocation ? $this->activeAllocation->room : null;
    }

    /**
     * Check if the user has a pending room application.
     */
    public function hasPendingApplication(): bool
    {
        return $this->roomApplications()->where('status', 'pending')->exists();
    }

    /**
     * Get the user's pending room application (if any).
     */
    public function pendingApplication()
    {
        return $this->roomApplications()->where('status', 'pending')->first();
    }
}