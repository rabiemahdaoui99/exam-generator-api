<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\ApiAnswerGenerator;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('/RCL', function () {
//     $w = new WeightConvert;
//     return $w->generateWeigthQuiz();
// });

Route::get('/ConvertWeights/{number?}', function ($number = 0) {
    if (intval($number) < 1) {
        return App::call('App\Http\Controllers\ApiAnswerGenerator@getWeights');
    }
    $data = $number;
    return App::call(
        'App\Http\Controllers\ApiAnswerGenerator@getWeights',
        ['numberOfQuestions' => $data]
    );
});
Route::get('/Range/{number?}', function ($number = 0) {
    if (intval($number) < 1) {
        return App::call('App\Http\Controllers\ApiAnswerGenerator@getRanges');
    }
    $data = $number;
    return App::call(
        'App\Http\Controllers\ApiAnswerGenerator@getRanges',
        ['numberOfQuestions' => $data]
    );
});
Route::get('/PoL/{number?}', function ($number = 0) {
    if (intval($number) < 1) {
        return App::call('App\Http\Controllers\ApiAnswerGenerator@getPartOfLines');
    }
    $data = $number;
    return App::call(
        'App\Http\Controllers\ApiAnswerGenerator@getPartOfLines',
        ['numberOfQuestions' => $data]
    );
});
Route::get('/Rcl/{name}/{number?}', function ($name = "total-weight", $number = 0) {
    if (intval($number) < 1) {
        return App::call(
            'App\Http\Controllers\ApiAnswerGenerator@getRcls',
            ['quizKey' => $name]
        );
    }
    return App::call(
        'App\Http\Controllers\ApiAnswerGenerator@getRcls',
        [
            'quizKey' => $name,
            'numberOfQuestions' => $number
        ]
    );
});
Route::get('/HandSignals/{number?}', function ($number = 0) {
    if (intval($number) < 1) {
        return App::call('App\Http\Controllers\ApiAnswerGenerator@getHandSignals');
    }
    $data = $number;
    return App::call(
        'App\Http\Controllers\ApiAnswerGenerator@getHandSignals',
        ['numberOfQuestions' => $data]
    );
});

Route::get('/image/handSignals/{name}', function ($name = 0) {
    $data = $name;
    return App::call(
        'App\Http\Controllers\ApiAnswerGenerator@signalImage',
        ['fileName' => $data]
    );
});

Route::get('/image/rcl/{name}', function ($name = 0) {
    $data = $name;
    return App::call(
        'App\Http\Controllers\ApiAnswerGenerator@rclImage',
        ['fileName' => $data]
    );
});
