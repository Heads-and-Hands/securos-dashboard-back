<?php

use App\Http\Controllers\ApiV1\VideoCameraController;
use App\Http\Controllers\ApiV1\VideoCameraPassportController;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'v1'], function () {
    Route::get('cameras/short', [VideoCameraController::class, 'camerasShort']);
    Route::get('cameras/ip-server', [VideoCameraController::class, 'camerasIpServer']);
    Route::resource('cameras', VideoCameraController::class)->only('index');
    Route::resource('camera/passport', VideoCameraPassportController::class)
        ->only(['store', 'show', 'update', 'destroy']);
});
