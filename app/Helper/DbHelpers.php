<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;


class DbHelpers
{
    public function insert(array $insertData)
    {
        Contact::insert($insertData);
    }

    public function chekcDuplicate($contact)
    {
        return is_null(Contact::where(['contact' => $contact])->first());
    }
}
