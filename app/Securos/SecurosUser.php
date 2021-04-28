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
        #TODO: Сделать единую авторизацию на 2 API, когда будет единая тестовая учетка
        //return self::getAuthHeader();

        return [
            'Authorization' => 'Basic MTox'
        ];

    }

    public static function checkAuthKey(string $key)
    {
        #TODO Убрать!!!
        if ($key == 'MTox') return false;

        $response = json_decode(BaseRequest::get(self::CHECK_AUTH_URL));
        return (isset($response->status) && ($response->status == 200));
    }

}
