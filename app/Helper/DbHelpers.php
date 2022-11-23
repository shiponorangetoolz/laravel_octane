<?php

namespace App\Helper;

use App\Models\Contact;
use App\Models\User;
use Exception;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;


use GuzzleHttp\Promise\Coroutine;
use Swoole\Constant;
use GuzzleHttp\Client;

use Yurun\Util\Swoole\Guzzle\SwooleHandler;
use function Swoole\Coroutine\go;
use function Swoole\Coroutine\run;

class DbHelpers
{
    public function insert(array $insertData)
    {
        Log::info('$insertData data count',[count($insertData)]);
        Contact::insert($insertData);
    }

    public function checkDuplicate($contact)
    {
        return App::make(Contact::class)->where(['contact' => $contact])->first();
    }

    public function curlRequest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
    }
}
