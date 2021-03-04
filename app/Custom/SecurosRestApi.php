<?php

namespace App\Custom;
  
use App\Custom\Contracts\SecurosAPI;
use Exception;
  
class SecurosRestApi implements SecurosAPI
{
    /* Непосредственный запрос к сервису и парсинг ответа */

    private function request($linkRes, $apiLogin, $apiPass)
    {
        $link = 'http://'.env('SECUROS_API_ADDRESS').':'.env('SECUROS_REST_PORT') . $linkRes;
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_USERPWD, $apiLogin . ":" . $apiPass);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $body = curl_exec($ch);
        $info = curl_getinfo($ch);

        if(curl_errno($ch))
        {
            throw new \Exception('SecurosAPI. Error: '.curl_error($ch).'. StatusCode: '.$info['http_code']);
        }
        curl_close($ch);        
        return json_decode($body);
    }

    /* Непосредственный запрос к сервису и парсинг ответа */

    public function requestFile($cam_id, $time, $path)
    {
        $rest_url = 'http://';
        $rest_url .= env('SECUROS_API_ADDRESS').':'.env('SECUROS_REST_PORT');
        $rest_url .= '/api/v2/cameras/'.$cam_id.'/image/';
        $rest_url .= str_replace(['-',':',' '], ['','','T'], $time);

        $fp = fopen($path, 'c');
        $ch = curl_init($rest_url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, env('SECUROS_API_LOGIN') . ":" . env('SECUROS_API_PASS'));
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);

        if(curl_errno($ch))
        {
            throw new \Exception('SecurosAPI. Error: '.curl_error($ch).'. StatusCode: '.$info['http_code']);
        }
        curl_close($ch);
        return (fwrite($fp,$data));
    }

    /* Массовый запрос камер */

    public function getCameras()
    {
        $rest_url = '/api/v1/cameras';
        $data = $this->request($rest_url, env('SECUROS_API_LOGIN'), env('SECUROS_API_PASS'));
        if(isset($data->status) && $data->status == 'success'){
            return $data->data;
        }else{
            throw new \Exception('SecurosAPI. Error getting cameras');
        }                
    }
}