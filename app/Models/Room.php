<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'type',               // now included (always 'single', but mass‑assignable)
        'capacity',           // now included (always 1, but mass‑assignable)
        'price_per_month',
        'status',
        'image',
        'archived',
    ];

    protected $casts = [
        'archived' => 'boolean',
    ];

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

    // ❌ building() relationship removed – buildings table no longer exists

    public function applications()
    {
        return $this->hasMany(RoomApplication::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function scopeActive($query)
    {
        return $query->where('archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }
}