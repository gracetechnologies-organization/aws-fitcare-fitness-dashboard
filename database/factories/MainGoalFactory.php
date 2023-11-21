<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MainGoal>
 */
class MainGoalFactory extends Factory
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
            'thumbnail_url' => $this->faker->randomElement(['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg', 'image5.png']),
        ];
    }
}
