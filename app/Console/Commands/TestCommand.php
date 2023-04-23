<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run tests.';

    /**
     * Execute the console command. (php artisan test)
     *
     * @return mixed
     */
    public function handle()
    {
        // Change directory to project root
        chdir(base_path());

        // Run tests using PHPUnit
        $process = new Process(['./vendor/bin/phpunit', 'tests']);
        $process->run();

        // Handle any errors that occur during the process
        if (!$process->isSuccessful())
            throw new ProcessFailedException($process);

        // Display the test results in the console
        $this->line($process->getOutput());
    }
}