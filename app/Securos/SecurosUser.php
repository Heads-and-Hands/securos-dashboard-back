<?php


namespace App\Securos;


class SecurosUser
{
    protected const CHECK_AUTH_URL = 'api/v1/cameras';

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

    public static function getImageAuthHeader()
    {
        return self::getAuthHeader();
    }

    public static function checkAuthKey(string $key)
    {
        self::$authKey = $key;
        $response = json_decode(BaseRequest::get(self::CHECK_AUTH_URL));
        return (isset($response->status) && ($response->status == 200));
    }

}
