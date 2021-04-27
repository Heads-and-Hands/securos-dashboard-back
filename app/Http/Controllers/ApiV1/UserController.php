<?php


namespace App\Http\Controllers\ApiV1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        #TODO проверка логина и пароля через SecurosAPI
        $request->session()->put('user_name', $request->input('login'));
        $request->session()->put('user_key', $request->input('key'));
        return response()->json(['message' => 'OK'], 200);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return response()->json(['message' => 'OK'], 200);
    }
}
