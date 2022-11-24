<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Octane\Facades\Octane;


class Helpers
{
    public static function runner(array $globalContact = [], array $itemsData = [], $batch)
    {
        $insertData = [];
//
//        $item = array_chunk($itemsData, 100);
//
//        $one = $item[0] ?? [];
//        $two = $item[1] ?? [];

        \yidas\WorkerDispatcher::run([
            'debug' => true,
            'workers' => 2,
            'config' => ['uri' => "/v1/resource"],
            'tasks' => false,
            'callbacks' => [
                'process' => function ($config, $workerId, $task) use ($insertData, $itemsData) {

                    for ($i = 1; $i < $itemsData; $i++) {
                        $contact = 100000000 . "" . $i;

                        $user = User::where(['id' => $i])->first();

                        if (!is_null($user)) {
                            $name = $user->name;
                        }

                        $db = new DbHelpers();

//                        $db->curlRequest();

                        $duplicate = $db->checkDuplicate($contact);
                        echo $duplicate;
                        if (is_null($duplicate)) {
                            $insertData[] = [
                                'uid' => "uid" . $i,
                                'contact' => $contact
                            ];
                        }


                    }
                    print_r($insertData);

                    $db = new DbHelpers();
                    $db->insert($insertData);
                },
            ],
        ]);


    }
}

