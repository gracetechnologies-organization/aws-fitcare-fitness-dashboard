<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abdullah:intro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Introduction to Abdullah';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->info("A Laravel contibutor from Pakistan");
        $this->info(User::all());
    }
}
