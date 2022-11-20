<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Laravel\Octane\Facades\Octane;

class PostController extends Controller
{
    public static function index()
    {
        $itemArray = [];
        $globalContact = [];
        $insertData = null;
        $resultOne = [];
        $resultTwo = [];


//        echo "Start" . Carbon::now()->format('Y-m-d H:i:s');
//        echo "\n";
        foreach (range(1, 1302000) as $key => $data) {

            $itemArray[] = $data;

            if (count($itemArray) > 6999) {
//                echo "Loop data ". $data  ;
//                echo "\n";
                $cool = array_chunk($itemArray, 3500);
                $first = $cool[0] ?? [];
                $second = $cool[1] ?? [];

                Log::info('step ---- ' . $key ,[Carbon::now()->format('H:i:s')]);
                [$resultOne, $resultTwo] = Octane::concurrently([
                    function () use (&$globalContact, $first) {
                        return Helpers::runner($globalContact, $first, "First ");
                    },

                    function () use (&$globalContact, $second) {
                        return Helpers::runner($globalContact, $second, "Second");
                    },
                ], 100000);
                Log::info('callback return',[$resultOne, $resultTwo]);

                Log::info('step ##### ',[Carbon::now()->format('H:i:s')]);

                $itemArray = [];
            }
        }

        Log::info('Last callback ',[$resultOne, $resultTwo]);


        echo "\n ######################################################## \n";
        echo "end " . Carbon::now()->format('Y-m-d H:i:s');

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
