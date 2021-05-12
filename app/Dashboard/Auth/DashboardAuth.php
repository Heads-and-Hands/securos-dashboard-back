<?php


namespace App\Dashboard\Auth;

use App\Securos\SecurosUser;
use Closure;

class DashboardAuth
{
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('user_key')) {
            SecurosUser::setAuthKey($request->session()->get('user_key'));
        }
        else {
            return response()->json(['message' => 'User Unauthorized'], 401);;
        }
        return $next($request);
    }
}
