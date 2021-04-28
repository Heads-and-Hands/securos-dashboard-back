<?php


namespace App\Securos;


class SecurosUser
{
    private static $authKey;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function setAuthKey($key)
    {
        self::$authKey = $key;
    }

    public static function getAuthHeader()
    {
        if (is_null(self::$authKey)) {
            return [];
        }
        else {
            return [
                'Authorization' => 'Basic ' . self::$authKey
            ];
        }
    }

}
