<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use Carbon\Carbon;
use Laravel\Octane\Facades\Octane;

class PostController extends Controller
{
    public static function index()
    {
        $itemArray = [];
        $globalContact = [];

        echo "Start" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";
        foreach (range(1, 1000010) as $data) {

            $itemArray[] = $data;

            if (count($itemArray) > 5999) {
                echo "Loop data ". $data  ;
                echo "\n";
                $cool = array_chunk($itemArray, 3000);
                $first = $cool[0] ?? [];
                $second = $cool[1] ?? [];
//                $three = $cool[2] ?? [];

                Octane::concurrently([
                    function () use (&$globalContact, $first) {
                        Helpers::runner($globalContact, $first, "First ");
                    },

                    function () use (&$globalContact, $second) {
                        Helpers::runner($globalContact, $second, "Second");
                    },
//                    function () use (&$globalContact, $three) {
//                        Helpers::runner($globalContact, $three, "three");
//                    }
                ], 100000);
                $itemArray = [];
            }
        }

        echo "\n ######################################################## \n";
        echo "end " . Carbon::now()->format('Y-m-d H:i:s');


//        Octane::concurrently([
//            function () {
//                $users = User::all();
//                foreach ($users as $user) {
//                    $user->update(['status' => 1]);
//                    Log::info('User Update: ', [Carbon::now()->format('Y-m-s')]);
//                }
//
//            },
//            function () {
//                $posts = Post::all();
//                foreach ($posts as $post) {
//                    $post->update(['status' => 1]);
//                    Log::info('Post Update: ', [Carbon::now()->format('Y-m-s')]);
//                }
//            },
//        ]);
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
