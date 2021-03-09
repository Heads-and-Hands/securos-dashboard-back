<?php
declare(strict_types=1);

namespace App\Custom;

use App\Custom\Contracts\SecurosAPI;
use Exception;

class SecurosRestApi implements SecurosAPI
{
    /* Непосредственный запрос к сервису и парсинг ответа */

    private function request($linkRes, $apiLogin, $apiPass)
    {
        $link = config('securos_api.securos_url') . $linkRes;

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_USERPWD, $apiLogin.":".$apiPass);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $body = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch)) {
            throw new Exception('SecurosAPI. Error: '.curl_error($ch).'. StatusCode: '.$info['http_code']);
        }
        curl_close($ch);

        return json_decode($body);
    }

    /* Непосредственный запрос к сервису и парсинг ответа */

    public function requestFile($camId, $time, $path)
    {
        $rest_url = config('securos_api.securos_url');
        $rest_url .= '/api/v2/cameras/'.$camId.'/image/';
        $rest_url .= str_replace(['-', ':', ' '], ['', '', 'T'], $time);

        $fp = fopen($path, 'c');
        $ch = curl_init($rest_url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, env('SECUROS_API_LOGIN').":".env('SECUROS_API_PASS'));
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch)) {
            throw new \Exception('SecurosAPI. Error: '.curl_error($ch).'. StatusCode: '.$info['http_code']);
        }

        curl_close($ch);

        return (fwrite($fp, $data));
    }

    /* Массовый запрос камер */

    public function getCameras()
    {
        $rest_url = '/api/v1/cameras';
        $data = $this->request($rest_url, config('securos_api.securos_api_login'), config('securos_api.securos_api_pass'));

        if (!isset($data->status) && $data->status !== 'success') {
            throw new \Exception('SecurosAPI. Error getting cameras');
        }

        return $data->data;
    }
}