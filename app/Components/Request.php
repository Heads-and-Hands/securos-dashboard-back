<?php
declare(strict_types=1);

namespace App\Components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use function GuzzleHttp\Psr7\build_query;

class Request
{
    protected static string $dataType = 'json';

    protected static function request($type, $url, $params = [], array $headers = [])
    {
        $response = self::requestRaw($type, $url, $params, $headers);
        return is_string($response) ? $response : $response->getBody()->getContents();
    }

    protected static function requestRaw($type, $url, $params = [], array $headers = [])
    {
        $client = new Client();
        try {
            return $client->request($type, $url,
                [
                    self::$dataType => $params,
                    'headers'       => $headers,
                ]
            );
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public static function get($url, array $params = [], array $headers = [])
    {
        if ($params) {
            $url .= '?' . build_query($params);
        }
        return self::request('GET', $url, [], $headers);
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

    public static function delete($url, array $params = [], array $headers = [])
    {
        return self::request('DELETE', $url, $params, $headers);
    }

    public static function setDataType(string $type)
    {
        self::$dataType = $type;
    }

    public static function resetDataType()
    {
        self::$dataType = 'json';
    }
}
