<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(2),
            'start_time' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'end_time' => $this->faker->unique()->dateTimeBetween("now", "30 days")
        ];
    }
}
