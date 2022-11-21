<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class HelpersTwo
{
    public static function runner(array $globalContact = [], array $items = [], $batch)
    {
//        $insertData = [];
//        $db = new DbHelpers();
//        $tt = $db->checkDuplicate('3123123123124234');



        foreach ($items as $key => $item) {

            Log::info('$items arra', [$item]);

//            $contact = 100000000 . "" . $item ;
//
//            $user = User::where(['id' => $item])->first();
//            $name = "";
//            if (!is_null($user)) {
//                $name = $user->name;
//            }
//
//            $db = new DbHelpers();
//            $tt = $db->checkDuplicate($contact);
//            Log::info('$tt',[$tt]);
//
//            if (is_null($tt)) {
//                $insertData[] = [
//                    'uid' => "uid" . $item,
//                    'contact' => $contact
//                ];
//            }

        }

//        $db = new DbHelpers();
//        $db->insert($insertData);

    }
}
