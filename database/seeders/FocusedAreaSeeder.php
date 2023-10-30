<?php

namespace Database\Seeders;

use App\Models\FocusedArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FocusedAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FocusedArea::factory()->count(5)->create();
    }
}
