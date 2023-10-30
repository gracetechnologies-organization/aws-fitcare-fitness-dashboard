<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * This code is NOT IN USE right now but, we need to keep it
 * In future, if we ever required this "token" module 
 * Then, please remove this comment
 */

 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Token>
 */
class TokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'token' => $this->faker->uuid()
        ];
    }
}
