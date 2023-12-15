<?php

namespace Database\Seeders;

use App\Models\Otp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Otp::factory()->count(5)->create();
    }
}
