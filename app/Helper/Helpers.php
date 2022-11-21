<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
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

//            $cURLConnection = curl_init();
//
//            curl_setopt($cURLConnection, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1');
//            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
//
//            $phoneList = curl_exec($cURLConnection);
//            curl_close($cURLConnection);
//
//            $jsonArrayResponse = json_decode($phoneList);
//
//            if (!empty($jsonArrayResponse)) {
//                echo 'Data found';
//            } else {
//                echo 'Data not found';
//            }

            $db = new DbHelpers();
            $tt = $db->checkDuplicate($contact);

            if (is_null($tt)) {
                $insertData[] = [
                    'uid' => "uid" . $item,
                    'contact' => $contact
                ];
            }

        }

        $db = new DbHelpers();
        $db->insert($insertData);

    }
}
