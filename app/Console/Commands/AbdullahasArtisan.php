<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AbdullahasArtisan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mirza {given_val}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->info(Command::SUCCESS);
        $this->info($this->argument('given_val'));
    }
}
