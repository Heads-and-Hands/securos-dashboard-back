<?php
declare(strict_types=1);

namespace App\Securos;

use App\Components\Request;
use function GuzzleHttp\Psr7\build_query;

class BaseRequest extends Request
{
    protected static function request($type, $url, $params = [], array $headers = [])
    {
        $apiUrl = env('SECUROS_DASHBOARD_URL');

        return parent::request($type, $apiUrl . $url, $params, $headers);
    }

    protected static function requestRaw($type, $url, $params = [], array $headers = [])
    {
        $apiUrl = env('SECUROS_DASHBOARD_URL');

        return parent::requestRaw($type, $apiUrl . $url, $params, $headers);
    }

    public static function get($url, array $params = [], array $headers = [])
    {
        if ($params) {
            $url .= '?' . build_query($params);
        }
        return self::request('GET', $url, [], $headers);
    }

    public static function getRaw($url, array $params = [], array $headers = [])
    {
        if ($params) {
            $url .= '?' . build_query($params);
        }
        return self::requestRaw('GET', $url, $params, $headers);
    }

    public static function post($url, array $params = [], array $queryParams = [])
    {
        if ($queryParams) {
            $url .= '?' . build_query($queryParams);
        }
        return self::request('POST', $url, $params);
    }

    public static function put($url, array $params = [], array $headers = [])
    {
        return self::request('PUT', $url, $params, $headers);
    }

    public static function patch($url, array $params = [], array $headers = [])
    {
        return self::request('PATCH', $url, $params, $headers);
    }

    public static function delete($url, array $params = [], array $headers = [])
    {
        return self::request('delete', $url, $params, $headers);
    }
}
