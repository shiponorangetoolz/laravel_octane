<?php

namespace App\Console\Commands;

use App\Helper\DbHelpers;
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
//        PostController::index();
        PostController::dispatcher();
//        PostController::newDispatcher();
        return Command::SUCCESS;
    }
}
