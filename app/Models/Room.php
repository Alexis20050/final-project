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
        'type',
        'capacity',
        'price_per_month',
        'status',
        'image',
        'building_id',
    ];

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
}