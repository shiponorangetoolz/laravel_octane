<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;


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

    public function curlRequest()
    {
        $cURLConnection = curl_init();

        curl_setopt($cURLConnection, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1');
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $phoneList = curl_exec($cURLConnection);
        curl_close($cURLConnection);

        $jsonArrayResponse = json_decode($phoneList);

        if ($jsonArrayResponse) {
            Log::info('Data Found');
        }

        return true;

    }
}
