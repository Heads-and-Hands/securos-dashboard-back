<?php
declare(strict_types=1);

namespace App\Securos;

use App\Components\Request;
use App\Exceptions\SecurosException;
use function GuzzleHttp\Psr7\build_query;

class BaseRequest extends Request
{
    /**
     * @throws SecurosException
     */
    protected static function request($type, $url, $params = [], array $headers = [])
    {
        $apiUrl = env('SECUROS_DASHBOARD_URL');
        $response = parent::request(
            $type, $apiUrl . $url, $params,
            array_merge($headers, SecurosUser::getAuthHeader()));
        self::checkResponse($response);
        return $response;
    }

    /**
     * @throws SecurosException
     */
    protected static function requestRaw($type, $url, $params = [], array $headers = [])
    {
        $apiUrl = env('SECUROS_DASHBOARD_URL');
        $response = parent::requestRaw(
            $type, $apiUrl . $url, $params,
            array_merge($headers, SecurosUser::getAuthHeader()));
        self::checkResponse($response);
        return $response;
    }

    /**
     * @throws SecurosException
     */
    private static function checkResponse($response)
    {
        $data = json_decode($response);
        if (isset($data->status) && $data->status > 300) {
            throw new SecurosException($response);
        }
    }

    /**
     * @throws SecurosException
     */
    public static function get($url, array $params = [], array $headers = [])
    {
        if ($params) {
            $url .= '?' . build_query($params);
        }
        return self::request('GET', $url, [], $headers);
    }

    /**
     * @throws SecurosException
     */
    public static function getRaw($url, array $params = [], array $headers = [])
    {
        if ($params) {
            $url .= '?' . build_query($params);
        }
        return self::requestRaw('GET', $url, $params, $headers);
    }

    /**
     * @throws SecurosException
     */
    public static function post($url, array $params = [], array $queryParams = [])
    {
        if ($queryParams) {
            $url .= '?' . build_query($queryParams);
        }
        return self::request('POST', $url, $params);
    }

    /**
     * @throws SecurosException
     */
    public static function put($url, array $params = [], array $headers = [])
    {
        return self::request('PUT', $url, $params, $headers);
    }

    /**
     * @throws SecurosException
     */
    public static function patch($url, array $params = [], array $headers = [])
    {
        return self::request('PATCH', $url, $params, $headers);
    }

    /**
     * @throws SecurosException
     */
    public static function delete($url, array $params = [], array $headers = [])
    {
        return self::request('delete', $url, $params, $headers);
    }
}
