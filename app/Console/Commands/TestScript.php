<?php

namespace App\Console\Commands;

use App\Http\Controllers\PostController;
use Illuminate\Console\Command;

class TestScript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:script';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        PostController::index();
        return Command::SUCCESS;
    }
}
