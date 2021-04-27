<?php


namespace App\Dashboard\Auth;


use Illuminate\Contracts\Auth\Authenticatable;

class DashboardGuard implements \Illuminate\Contracts\Auth\Guard
{

    /**
     * @inheritDoc
     */
    public function check()
    {
        return !is_null(session('user_key'));
    }

    /**
     * @inheritDoc
     */
    public function guest()
    {
        return is_null(session('user_key'));
    }

    /**
     * @inheritDoc
     */
    public function user()
    {
        return new DashboardAuthenticatable('user_name', session('user_key'));
    }

    /**
     * @inheritDoc
     */
    public function id()
    {
        return session('user_key');
    }

    /**
     * @inheritDoc
     */
    public function validate(array $credentials = [])
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function setUser(Authenticatable $user)
    {
    }
}
