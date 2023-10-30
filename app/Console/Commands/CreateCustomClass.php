<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateCustomClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:custom-class {class_name} {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will create a custom class with the specified path.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $classPath = $this->argument('path');
        $className = $this->argument('class_name');
        $classContent = <<<EOT
                            <?php

                            class $className
                            {
                                public function defineYourFunc()
                                {
                                    //
                                }
                            }
                        EOT;
        $directoryPath = $classPath ? app_path($classPath) : app_path();
        // Create the directory if it doesn't exist
        if (!file_exists($directoryPath)) mkdir($directoryPath, 0755, true);
        $file = $directoryPath . "/{$className}.php";
        file_put_contents($file, $classContent);

        $this->info($directoryPath . "/{$className}.php created successfully.");
        return Command::SUCCESS;
    }
}
