<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;


class Helpers
{
    public static function runner(array $globalContact = [], array $items = [], $batch): void
    {
        $insertData = [];

        foreach ($items as $key => $item) {

            $contact = 100000000 . "" . $item ;

            $user = User::where(['id' => $item])->first();
            $name = "";
            if (!is_null($user)) {
                $name = $user->name;
            }

            if (is_null(Contact::where(['contact' => $contact])->first())) {
                $insertData[] = [
                    'uid' => "uid" . $item,
                    'contact' => $contact
                ];
            }

        }

        Contact::insert($insertData);
    }
}
