<?php
declare(strict_types=1);

namespace App\Securos;

class SecurosCameraPassport extends BaseRequest
{
    protected const CAMERAS_PASSPORT_CREATE_URL = 'api/v1/passports';
    protected const CAMERAS_PASSPORT_UPDATE_URL = 'api/v1/passports/';
    protected const CAMERAS_PASSPORT_DELETE_URL = 'api/v1/passports/';
    protected const CAMERAS_PASSPORT_APPROVE_URL = 'api/v1/passports/';

    public static function getCameraPassport(string $url)
    {
        $requestUrl = $url;
        if (str_starts_with($requestUrl, '/')) {
            $requestUrl = substr($requestUrl, 1);
        }
        $data = parent::get($requestUrl);
        return json_decode($data);
    }

    public static function createCameraPassport(int $passportId, $passportParams)
    {
        $params = self::prepareParams($passportId, $passportParams);
        $data = parent::post(self::CAMERAS_PASSPORT_CREATE_URL, $params);
        return json_decode($data);
    }

    private static function prepareParams(int $passportId, $passportParams)
    {
        return [
            'id' => (string) $passportId,
            'stream' => [
                'fps' => intval($passportParams['fps']),
                'kbps' => intval($passportParams['kbps']),
                'width' => intval($passportParams['width']),
                'height' => intval($passportParams['height'])
            ]
        ];
    }

    public static function deleteCameraPassport($passportId)
    {
        $url = self::CAMERAS_PASSPORT_DELETE_URL. $passportId;
        $data = parent::delete($url);
        return json_decode($data);
    }

    public static function approveCameraPassport($passportId)
    {
        $url = self::CAMERAS_PASSPORT_APPROVE_URL. $passportId;
        $data = parent::patch($url);
        return json_decode($data);
    }

    public static function updateCameraPassport(int $passportId, $passportParams)
    {
        $params = self::prepareParams($passportId, $passportParams);
        $data = parent::put(self::CAMERAS_PASSPORT_UPDATE_URL . $passportId, $params);
        return json_decode($data);
    }
}
