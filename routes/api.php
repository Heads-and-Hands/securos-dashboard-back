<?php

use App\Http\Controllers\ApiV1\{JobController, ReportController, VideoCameraController, VideoCameraPassportController};
use App\Http\Controllers\ApiV1\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use \Symfony\Component\HttpKernel\Exception\HttpException;
use App\Dashboard\Auth\DashboardUser;

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
    Route::post('login', [UserController::class, 'login']);
    Route::get('logout', [UserController::class, 'logout']);

    Route::group(['middleware' => 'auth.dashboard'], function () {
        Route::get('check/job', [JobController::class, 'checkJob']);
        Route::get('cameras/short', [VideoCameraController::class, 'camerasShort']);
        Route::get('cameras/ip-server', [VideoCameraController::class, 'camerasIpServer']);
        Route::get('unverified/passport', [VideoCameraController::class, 'checkUnverifiedPassport']);
        Route::resource('cameras', VideoCameraController::class)->only('index');
        Route::get('camera/passport/{camera}', [VideoCameraPassportController::class, 'show']);
        Route::post('camera/passport/{camera}', [VideoCameraPassportController::class, 'store']);
        Route::put('camera/passport/{camera}', [VideoCameraPassportController::class, 'update']);
        Route::patch('camera/passport/{camera}', [VideoCameraPassportController::class, 'approve']);
        Route::delete('camera/passport/{camera}', [VideoCameraPassportController::class, 'destroy']);
        Route::resource('report/{exportReportClass?}', ReportController::class)->only(['index']);
    });
});
#TODO: Удалить
// Рабочий URL для экспорта в Excel:
// 127.0.0.1:28591/api/v1/report/excel?ids=1,2,3,11&rangeOfDate=20210428T130000-20210501T120000&timezoneOffset=-180
// (привязка значений exportReportClass к конкретным классам прописана в методе boot() класса RouteServiceProvider)
