<?php


namespace App\Dashboard\Auth;


class DashboardUser
{
    public static function getName()
    {
        return session('user_name');
    }

    public static function getKey()
    {
        return session('user_key');
    }
}
