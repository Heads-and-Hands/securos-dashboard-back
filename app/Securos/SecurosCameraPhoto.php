<?php
declare(strict_types=1);

namespace App\Securos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SecurosCameraPhoto extends BaseRequest
{
    public static function getPhoto($id)
    {
        $url = env('SECUROS_DASHBOARD_URL_PHOTO'). "api/v2/cameras/$id/image";
        $data = self::getRequest($url, 'GET');

        if (!$data) {
            return null;
        }

        return self::getPhotoBase64($data);
    }

    public static function getPhotoBase64($data)
    {
        $body = $data->getBody()->getContents();
        $base64 = base64_encode($body);
        $mime = "image/jpeg";
        return ('data:' . $mime . ';base64,' . $base64);
    }

    public static function getRequest($url, $type, $params = [], array $headers = [])
    {
        $client = new Client();
        try {
            return $client->request($type, $url,
                [
                    'json' => $params,
                    'headers' => array_merge($headers, SecurosUser::getImageAuthHeader()),
                ]
            );
        } catch (GuzzleException $e) {
            return null;
        }
    }
}
