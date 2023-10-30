<?php

namespace Database\Seeders;

use App\Models\Token;
use Illuminate\Database\Seeder;


/**
 * This code is NOT IN USE right now but, we need to keep it
 * In future, if we ever required this "token" module 
 * Then, please remove this comment
 */

 
class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Token::factory()->count(5)->create();
    }
}
