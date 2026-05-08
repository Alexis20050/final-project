<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_number',
        'price_per_month',
        'status',
        'image',
        'building_id',
        'archived',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'archived' => 'boolean',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * Forces every room to be a single room with capacity 1.
     */
    protected static function booted()
    {
        static::creating(function ($room) {
            $room->type = 'single';
            $room->capacity = 1;
        });

        static::updating(function ($room) {
            $room->type = 'single';
            $room->capacity = 1;
        });
    }

    /**
     * Get the building that owns the room.
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the room applications for this room.
     */
    public function applications()
    {
        return $this->hasMany(RoomApplication::class);
    }

    /**
     * Get the allocations for this room.
     */
    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }

    /**
     * Get the maintenance requests for this room.
     */
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    /**
     * Scope a query to only include active (non‑archived) rooms.
     */
    public function scopeActive($query)
    {
        return $query->where('archived', false);
    }

    /**
     * Scope a query to only include archived rooms.
     */
    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }
}