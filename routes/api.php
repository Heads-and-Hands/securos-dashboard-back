<?php

use App\Http\Controllers\ApiV1\{JobController, ReportController, VideoCameraController, VideoCameraPassportController};
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
    Route::get('check/job', [JobController::class, 'checkJob']);
    Route::get('cameras/short', [VideoCameraController::class, 'camerasShort']);
    Route::get('cameras/ip-server', [VideoCameraController::class, 'camerasIpServer']);
    Route::get('unverified/passport', [VideoCameraController::class, 'checkUnverifiedPassport']);
    Route::resource('cameras', VideoCameraController::class)->only('index');
    /*
    Route::resource('camera/passport', VideoCameraPassportController::class)
        ->only(['store', 'show', 'update', 'destroy']);
    */
    Route::get('camera/passport/{camera}', [VideoCameraPassportController::class, 'show']);
    Route::post('camera/passport/{camera}', [VideoCameraPassportController::class, 'store']);
    Route::put('camera/passport/{camera}', [VideoCameraPassportController::class, 'update']);
    Route::patch('camera/passport/{camera}', [VideoCameraPassportController::class, 'approve']);
    Route::delete('camera/passport/{camera}', [VideoCameraPassportController::class, 'destroy']);

    Route::resource('report/{exportReportClass?}', ReportController::class)->only(['index']);
});
