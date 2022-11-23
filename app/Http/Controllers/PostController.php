<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use App\Helper\Status;
use App\Imports\FileImport;
use App\Models\Contact;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Laravel\Octane\Events\TaskTerminated;
use Laravel\Octane\Facades\Octane;

use Laravel\Octane\Swoole\SwooleCoroutineDispatcher;
use Laravel\Octane\Swoole\SwooleExtension;
use Laravel\Octane\Swoole\SwooleHttpTaskDispatcher;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\Environment\Runtime;
use Swoole\Coroutine;
use Yurun\Util\Swoole\Guzzle\SwooleHandler;

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
                $chunkDataForConcurrent = array_chunk($itemArray, 3000);
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
}
