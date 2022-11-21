<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use App\Imports\FileImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Laravel\Octane\Facades\Octane;

use Maatwebsite\Excel\Facades\Excel;

class PostTwoController extends Controller
{
    public static function processFile()
    {

        $arr = [1, 2, 3, 4, 5];
        Cache::store('octane')->put('shipon', $arr, 30);

        $data = Cache::store('octane')->get('shipon');
        dd($data);

        $path = public_path('file');
        $files = File::files($path);

        foreach ($files as $key => $file) {
            Octane::concurrently([
                function () use (&$file) {
                    $fileData = Excel::toArray(new FileImport, $file);

                    (new PostController())->index($fileData);
                    return true;
                }
            ]);

        }
    }

    public function index($fileData)
    {
        $itemArray = [];
        $globalContact = [];
        $insertData = null;
        $resultOne = [];
        $resultTwo = [];


        echo "Start" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";


        foreach ($fileData[0] as $data) {
            $itemArray[] = $data;

            if (count($itemArray) > 5) {

                $cool = array_chunk($itemArray, 2);
                $first = $cool[0] ?? [];
                $second = $cool[1] ?? [];


                [$resultOne, $resultTwo] = Octane::concurrently([
                    function () use (&$first) {
                        return true;

//                        Helpers::runner($globalContact, $first, "First ");
                    },

                    function () use (&$second) {

//                        Helpers::runner($globalContact, $second, "Second");
                        return true;
                    },

                ], 100000);

                $itemArray = [];
            }
        }

        return true;

    }

    public function printOne()
    {
        sleep(2);
        echo Carbon::now()->format('Y-m-s') . '<br>';
    }

    public function printTwo()
    {
        sleep(2);
        echo Carbon::now()->format('Y-m-s');
    }
}
