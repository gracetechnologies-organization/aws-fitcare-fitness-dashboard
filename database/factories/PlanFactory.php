<?php

namespace Database\Factories;

use App\Models\MainGoal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
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
            'description' => $this->faker->realText(20),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'thumbnail_url' => $this->faker->randomElement(['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg', 'image5.png']),
            'goal_id' => MainGoal::inRandomOrder()->first()->id
        ];
    }
}
