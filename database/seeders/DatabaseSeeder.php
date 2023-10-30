<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            LevelSeeder::class,
            ProgramSeeder::class,
            ExerciseSeeder::class,
            TokenSeeder::class,
            FocusedAreaSeeder::class,
            WorkoutSeeder::class,
            WorkoutFocusedAreaSeeder::class
        ]);
    }
}
