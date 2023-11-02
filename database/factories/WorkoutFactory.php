<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workout>
 */
class WorkoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->unique()->word),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'thumbnail_url' => $this->faker->randomElement(['workout1.jpg', 'workout2.jpg', 'workout3.jpg', 'workout4.jpg', 'workout5.png']),
        ];
    }
}
