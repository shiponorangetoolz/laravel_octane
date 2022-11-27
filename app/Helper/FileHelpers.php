<?php

namespace App\Helper;

use App\Imports\FileImport;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Octane\Facades\Octane;
use Maatwebsite\Excel\Facades\Excel;


class FileHelpers
{

    public static function runner(array $globalContact = [], $items = null, $batch)
    {

        echo "Start worker file process" . " ";
        echo "\n";

        $fileArray = Excel::toArray(new FileImport, $items);

        echo "End" . " " . count($fileArray);
        echo "\n";

        // Split 7000 rows in 2 array and provide in multiple workers.
        $chunkDataForConcurrent = array_chunk($fileArray[0], 100);

        $one = $chunkDataForConcurrent[0] ?? [];
        $two = $chunkDataForConcurrent[1] ?? [];

        WorkerDispatcher::run([
            'debug' => true,
            'workers' => 3,
            'config' => ['uri' => "/v1/resource"],
            'tasks' => [
                $one,
                $two
            ],
            'callbacks' => [
                'task' => function ($config, $workerId, $task) use ($globalContact) {

                    $insertData = [];

                    foreach ($task as $key => $item) {

                        $contact = $item[5];
                        $user = User::where(['id' => $key])->first();

                        if (!is_null($user)) {
                            $name = $user->name;
                        }

                        $db = new DbHelpers();
                        //            $db->curlRequest();
                        //            $db->curlRequestDispatch();

                        $duplicate = $db->checkDuplicate($contact);

                        if (is_null($duplicate)) {
                            $insertData[] = [
                                'uid' => Str::uuid(),
                                'contact' => $contact
                            ];
                        }

                    }

                    $db = new DbHelpers();
                    $db->insert($insertData);
                },
            ],
        ]);

        $itemArray = [];

        echo "end worker file process" . " ";
        echo "\n";


    }
}

