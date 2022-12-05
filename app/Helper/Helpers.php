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

    public static function runner(array $globalContact = [], array $items = [], $batch)
    {

        $insertData = [];

        foreach ($items as $key => $item) {
            $contact = 100000000 . "" . $item;

            $user = User::where(['id' => $item])->first();

            if (!is_null($user)) {
                $name = $user->name;
            }

            $db = new DbHelpers();
//            $db->curlRequest();
//            $db->curlRequestDispatch();

            $duplicate = $db->checkDuplicate($contact);

            if (is_null($duplicate)) {
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

