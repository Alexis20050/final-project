<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Database\Seeder;

class BuildingRoomSeeder extends Seeder
{
    public function run()
    {
        $building = Building::create([
            'name' => 'Main Hall',
            'address' => '123 University Ave'
        ]);

        Room::create([
            'building_id' => $building->id,
            'room_number' => '101',
            'type' => 'single',
            'capacity' => 1,
            'price_per_month' => 5000,
            'status' => 'available'
        ]);

        Room::create([
            'building_id' => $building->id,
            'room_number' => '102',
            'type' => 'double',
            'capacity' => 2,
            'price_per_month' => 8000,
            'status' => 'available'
        ]);
    }
}