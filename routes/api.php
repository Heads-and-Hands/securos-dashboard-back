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

/*
Route::post('/login', function(Request $request) {
    if ($request->has('login') && $request->has('password')) {

        // Проверка логина и пароля может быть добавлена здесь

        $request->session()->put('user_name', $request->input('login'));
        $request->session()->put(
            'user_key',
            $request->input('login') . $request->input('password'));

        return redirect()->route('test');
    }
    else {
        throw new HttpException(403);
    }
})->name('login');

Route::get('/logout', function(Request $request) {
    $request->session()->flush();
    return 'OK';
})->name('logout');*/

/*
Route::middleware('auth.dashboard')->get('/test', function (Request $request) {
    $response['user'] = [
        'name' => DashboardUser::getName(),
        'key' => DashboardUser::getKey(),
    ];
    var_dump($response);
})->name('test');*/

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('test', [UserController::class, 'test'])->middleware('auth.dashboard');
});


Route::group(['prefix' => 'v1'], function () {
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
