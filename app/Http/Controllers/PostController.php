<?php

namespace App\Http\Controllers;

use App\Helper\FileHelpers;
use App\Helper\Helpers;
use App\Helper\Status;
use App\Helper\WorkerDispatcher;
use App\Imports\FileImport;
use App\Models\Contact;
use Carbon\Carbon;
use Fiber;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Octane\Events\TaskTerminated;
use Laravel\Octane\Facades\Octane;

use Laravel\Octane\Swoole\SwooleCoroutineDispatcher;
use Laravel\Octane\Swoole\SwooleExtension;
use Laravel\Octane\Swoole\SwooleHttpTaskDispatcher;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\Environment\Runtime;
use Swoole\Coroutine;

class PostController extends Controller
{
    public static function index()
    {
        $itemArray = [];
        $globalContact = [];

        echo "Start" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";

        // Generate number between 1 to 13000000 rows
        foreach (range(1, 13000000) as $data) {
            $itemArray[] = $data;

            // Cache array into octane cache store
            Cache::store('octane')->put('itemArray', $itemArray, 30);
            $itemsArray = Cache::store('octane')->get('itemArray');

            // Chunk array into 7000 rows. $itemsArray data access form octane cache store
            if (count($itemsArray) > 6999) {

                // Split 7000 rows in 2 array and provide in multiple workers.
                $chunkDataForConcurrent = array_chunk($itemArray, 1000);
                $firstWorkerData = $chunkDataForConcurrent[0] ?? [];
                $secondWorkerData = $chunkDataForConcurrent[1] ?? [];

                // Workers for parallel process
                Octane::concurrently([
                    function () use (&$globalContact, $firstWorkerData) {
                        Helpers::runner($globalContact, $firstWorkerData, "First Worker");
                    },

                    function () use (&$globalContact, $secondWorkerData) {
                        Helpers::runner($globalContact, $secondWorkerData, "Second Worker");
                    },

                ], 900000); // Workers will auto close after 900000 millisecond if no process found

                $itemArray = [];
            }
        }

        echo "End" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";

        return true;
    }

    public static function dispatcher()
    {
        $itemArray = [];
        $globalContact = [];


        echo "Start" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";

//        120000 , 29999 , 3000

        foreach (range(1, 2000000) as $data) {
            $itemArray[] = $data;

            if (count($itemArray) > 29999) {
                echo "Start worker file access" . " ";
                echo "\n";

                // Split 7000 rows in 2 array and provide in multiple workers.
                $chunkDataForConcurrent = array_chunk($itemArray, 5000);

                $one = $chunkDataForConcurrent[0] ?? [];
                $two = $chunkDataForConcurrent[1] ?? [];
                $three = $chunkDataForConcurrent[2] ?? [];
                $four = $chunkDataForConcurrent[3] ?? [];
                $five = $chunkDataForConcurrent[4] ?? [];
                $six = $chunkDataForConcurrent[5] ?? [];

                WorkerDispatcher::run([
                    'debug' => true,
                    'workers' => 4,
                    'config' => ['uri' => "/v1/resource"],
                    'tasks' => [
                        $one,
                        $two,
                        $three,
                        $four,
                        $five,
                        $six
                    ],
                    'callbacks' => [
                        'task' => function ($config, $workerId, $task) use ($globalContact) {
                           Helpers::runner($globalContact, $task, "First Worker");
                        },
                    ],
                ]);

                $itemArray = [];

                echo "End worker file access" . " ";
                echo "\n";
            }
        }

        echo "End" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";

        return true;
    }

    public static function newDispatcher()
    {

//        $files = array_chunk(File::files(public_path('file')), 3);
        $files = File::files(public_path('newFile'));

//        $fileOne = $files[0][0] ?? [];
//        $fileTwo = $files[0][1] ?? [];
//        $fileThree = $files[0][2] ?? [];


//        $fileArray = Excel::toArray(new FileImport, $fileOne);

        $itemArray = [];
        $globalContact = [1, 2, 3];


        echo "Start" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";

//        120000 , 29999 , 3000

        foreach ($files as $data) {
            $itemArray[] = $data;

            echo "Start worker file access" . " ";
            echo "\n";

            WorkerDispatcher::run([
                'debug' => true,
                'workers' => 1,
                'config' => ['uri' => "/v1/resource"],
                'tasks' => [
                    $data
                ],
                'callbacks' => [
                    'task' => function ($config, $workerId, $task) use ($globalContact) {
                        FileHelpers::runner($globalContact, $task, "First Worker");
                    },
                ],
            ]);

            $itemArray = [];

            echo "End worker file access" . " ";
            echo "\n";

        }

        echo "End" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";

        return true;
    }
}
