<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Helpers
{
    public static function runner(array $globalContact = [], array $items = [], $batch)
    {
        $insertData = [];

        foreach ($items as $key => $item) {
            $contact = 100000000 . "" . $item;

            $user = User::where(['id' => $item])->first();
            $name = "";

            if (!is_null($user)) {
                $name = $user->name;
            }

            $db = new DbHelpers();
            $db->curlRequest();
            sleep(1);

            $tt = $db->checkDuplicate($contact);

            $dbconnect = DB::connection()->getPDO();
            $dbname = DB::connection()->getDatabaseName();

            if (is_null($tt)) {
                $insertData[] = [
                    'uid' => "uid" . $item,
                    'contact' => $contact
                ];
            }

        }

        Log::info('DB::$insertData ',[$insertData]);
        Log::info('Data insert');
        $db = new DbHelpers();
        $db->insert($insertData);

    }
}
