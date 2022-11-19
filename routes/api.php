<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Octane\Facades\Octane;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function (){
    for ($i=0;$i < 20000; $i++){
        echo $i .'<br>';
    }

});

Route::get('test/one', function (){
//    \App\Models\Post::factory()->count(1000)->create();
    \App\Models\User::factory()->count(1000)->create();
    echo 'Ok Done';
});

Route::get('co', function (){
    Octane::concurrently([
        function () {
            sleep(2);
            echo 'first';
        },
        function () {
            sleep(2);
            echo 'second'.'</br>';
        },
    ]);
});

Route::get('index', [\App\Http\Controllers\PostController::class,'index']);
