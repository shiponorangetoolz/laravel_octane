<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\App;


class DbHelpers
{
    public function insert(array $insertData)
    {
        Contact::insert($insertData);
    }

    public function checkDuplicate($contact)
    {
        return App::make(Contact::class)->where(['contact' => $contact])->first();
    }
}
