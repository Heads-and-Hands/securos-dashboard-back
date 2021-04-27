<?php


namespace App\Dashboard\Auth;

use Closure;

class DashboardAuth
{
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('user_key')) {
            return response()->json(['message' => 'User Unauthorized'], 403);;
        }
        return $next($request);
    }
}
