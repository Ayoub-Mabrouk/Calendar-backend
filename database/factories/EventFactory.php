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
        $startingDate = $this->faker->dateTimeThisYear('-1 month', '+1 month');
        $endingDate   =  $this->faker->dateTimeThisYear('+1 month', '+2 month');
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(2),
            'start_time' => $startingDate,
            'end_time' => $endingDate,
        ];
    }
}
