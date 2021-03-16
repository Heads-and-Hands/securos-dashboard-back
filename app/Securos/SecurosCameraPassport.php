<?php
declare(strict_types=1);

namespace App\Securos;

class SecurosCameraPassport extends BaseRequest
{
    protected const CAMERAS_PASSPORT_CREATE_URL = 'api/v1/passports';
    protected const CAMERAS_PASSPORT_DELETE_URL = 'api/v1/passports/';

    public static function createCameraPassport($passport)
    {
        $data = parent::post(self::CAMERAS_PASSPORT_CREATE_URL, $passport);

        return json_decode($data);
    }

    public static function deleteCameraPassport($passportId)
    {
        $url = self::CAMERAS_PASSPORT_DELETE_URL. $passportId;

        $data = parent::delete($url);

        return json_decode($data);
    }

}
