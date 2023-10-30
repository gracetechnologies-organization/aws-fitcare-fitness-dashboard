<?php

namespace Database\Seeders;

use App\Models\WorkoutFocusedArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkoutFocusedAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkoutFocusedArea::factory()->count(5)->create();
    }
}
