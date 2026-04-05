<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [   'room_number' => 'R-' . fake()->unique()->numberBetween(101, 200),
        'type' => fake()->randomElement(['single', 'double', 'dormitory']),
        'capacity' => fake()->numberBetween(1, 6),
        'price_per_month' => fake()->randomFloat(2, 3000, 12000),
        'status' => fake()->randomElement(['available', 'occupied', 'maintenance']),
            //
        ];
    }
}
