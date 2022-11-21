<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use App\Imports\FileImport;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Laravel\Octane\Facades\Octane;

use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    public static function processFile()
    {
        ///
        $path = public_path('file');
        $files = File::files($path);

        foreach ($files as $file) {

            $fileData = Excel::toArray(new FileImport, $file);

            Octane::concurrently([
                function () use (&$fileData) {
                    (new PostController())->index($fileData);
                    return true;
                }
            ]);

        }
    }

    public static function index()
    {
        $contacts = Contact::select('contact')->get()->pluck('contact')->toArray();

        Cache::store('octane')->put('contacts', $contacts, 30);

        $contactData = Cache::store('octane')->get('contacts');

        $contactDataCollect = $contactData;
//        $contactDataCollect = collect($contactData);
//
//        $contactExist = $contactData->where('contact', '1000000008')->first();
//        dd($contactExist);

        $itemArray = [];
        $globalContact = [];
        $insertData = null;
        $resultOne = [];
        $resultTwo = [];

        echo "Start" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";

        foreach (range(1, 1000000) as $data) {
            $itemArray[] = $data;

            Cache::store('octane')->put('itemArray', $itemArray, 30);
            $itemsArray = Cache::store('octane')->get('itemArray');

            if (count($itemsArray) > 5999) {
                $cool = array_chunk($itemArray, 3000);
                $first = $cool[0] ?? [];
                $second = $cool[1] ?? [];


                [$resultOne, $resultTwo] = Octane::concurrently([
                    function () use (&$globalContact, $first) {
                        Helpers::runner($globalContact, $first, "First ");
                    },

                    function () use (&$globalContact, $second) {
                        Helpers::runner($globalContact, $second, "Second");
                    },

                ], 600000);

                $itemArray = [];
            }
        }

        echo "End" . Carbon::now()->format('Y-m-d H:i:s');
        echo "\n";

        return true;
    }

    public function printOne()
    {
        sleep(2);
        echo Carbon::now()->format('Y-m-s') . '<br>';
    }

    public function printTwo()
    {
        sleep(2);
        echo Carbon::now()->format('Y-m-s');
    }
}
