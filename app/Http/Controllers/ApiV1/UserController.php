<?php


namespace App\Http\Controllers\ApiV1;


use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1\LoginRequest;
use App\Dashboard\Auth\DashboardUser;
use App\Securos\SecurosUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $login = $request->input('login');
        $key = $request->input('key');

        if (SecurosUser::checkAuthKey($key)) {
            $request->session()->put('user_name', $login);
            $request->session()->put('user_key', $key);
            return response()->json(['message' => 'OK'], 200);
        }
        else {
            return response()->json(['message' => 'Incorrect login:password'], 403);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return response()->json(['message' => 'OK'], 200);
    }

    #TODO: Удалить закомментированное
    /*
    public function test(Request $request)
    {
        $response['user'] = [
            'name' => DashboardUser::getName(),
            'key' => DashboardUser::getKey(),
        ];
        return response()->json(SecurosUser::getAuthHeader(), 200);
    }*/

}
