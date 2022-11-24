<?php

namespace App\Helper;

/**
 * In this example, six non-blocking HTTP/1 requests are made by enabling option "SWOOLE_HOOK_CURL" for the curl
 * extension.
 * Each request takes about two seconds to finish; however, since the requests are made in non-blocking mode, it takes
 * barely over two seconds to finish all the requests.
 *
 * Notes:
 *     * This feature works under Swoole 4.4.0+.
 *     * This approach doesn't work for curl_multi_* functions. To hook curl_multi_* functions, please check the other
 *       example in file "./hooks/native-curl.php".
 *
 * How to run this script:
 *     docker compose exec -t client bash -c "./hooks/curl.php"
 *
 * You can run following command to see how much time it takes to run the script:
 *     docker compose exec -t client bash -c "time ./hooks/curl.php"
 */

use Exception;
use Illuminate\Support\Facades\Log;
use Swoole\Constant;
use Swoole\Coroutine;
use Swoole\Coroutine\Http\Client;

use function Swoole\Coroutine\go;
use function Swoole\Coroutine\run;

class SwooleHelper
{

    public function curTest($batch)
    {
        Coroutine::set([Constant::OPTION_HOOK_FLAGS => SWOOLE_HOOK_ALL]);
        Coroutine::set([Constant::OPTION_TASK_ENABLE_COROUTINE => true]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        Log::info('$statusCode swoole',[$statusCode, $batch]);

//        if ($statusCode !== 234) {
//            throw new Exception('Status code returned from the built-in HTTP/1 server should be 234.');
//        }

//        run(function () {
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1');
//            curl_setopt($ch, CURLOPT_HEADER, false);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_exec($ch);
//            $statusCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
//            curl_close($ch);
//
//            if ($statusCode !== 234) {
//                throw new Exception('Status code returned from the built-in HTTP/1 server should be 234.');
//            }
//
//        });
    }
}
