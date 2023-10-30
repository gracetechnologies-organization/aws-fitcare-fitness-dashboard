<?php

namespace Database\Factories;

use App\Models\FocusedArea;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class WorkoutFocusedAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'workout_id' => Workout::inRandomOrder()->first()->id,
            'focused_area_id' => FocusedArea::inRandomOrder()->first()->id,
        ];
    }
}
