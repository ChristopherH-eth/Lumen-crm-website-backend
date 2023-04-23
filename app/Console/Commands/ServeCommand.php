<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve {port=8000 : The port to serve the application on}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a development server.';

    /**
     * Execute the console command. (php artisan serve)
     *
     * @return mixed
     */
    public function handle()
    {
        $host = 'localhost';
        $port = 8000;
        $publicPath = base_path('public');

        $this->info("Server started on http://{$host}:{$port}/");

        exec("php -S {$host}:{$port} -t {$publicPath}");
    }
}