<?php

namespace App\Console\Commands;

use App\Helper\Poem\GeneratorClass;
use App\Helper\Poem\RandomPoemGenerator;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTwoController;
use Fiber;
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

    public function testFiber()
    {
        $fiber = new Fiber(function (): void {

            $value = Fiber::suspend("yyurutruytutrutrur");

            var_dump($value);
        });

        $d = $fiber->start();
        echo $d;

        echo $fiber->isStarted();


        $fiber->resume(range(1, 20));


        echo "final end  \n";

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $gn = new RandomPoemGenerator();
        $gn->data();

//        GeneratorClass::generatorPoem();
        PostController::index();
//        PostTwoController::processFile();
        return Command::SUCCESS;
    }
}
