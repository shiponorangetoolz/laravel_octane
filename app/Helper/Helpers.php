<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class Helpers
{
    public static function runner(array $globalContact = [], array $items = [], $batch)
    {
        $insertData = [];

        foreach ($items as $key => $item) {

            $contact = 100000000 . "" . $item ;

            $user = User::where(['id' => $item])->first();
            $name = "";
            if (!is_null($user)) {
                $name = $user->name;
            }

            $db = new DbHelpers();
            if ($db->chekcDuplicate($contact)) {
                $insertData[] = [
                    'uid' => "uid" . $item,
                    'contact' => $contact
                ];
            }

        }

        return [Carbon::now()->format('H:i:s')];


    }
}
