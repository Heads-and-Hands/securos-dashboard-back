<?php
declare(strict_types=1);

namespace App\Securos;

use App\Models\ApiV1\VideoCamera;

class SecurosCameras extends BaseRequest
{
    protected const CAMERAS_URL = 'api/v1/cameras';

    public static function getCameras(): array
    {
        $data = parent::get(self::CAMERAS_URL);
        $cameras = json_decode($data)->data;

        return self::formatCameras($cameras);
    }

    public static function formatCameras($cameras):array
    {
        $data = [];

        foreach ($cameras as $camera) {
            $data[] = [
                'id' => $camera->id,
                'ip' => $camera->ip ?: '0.0.0.0',
                'name' => $camera->name,
                'type' => self::getType($camera->ptz),
                'ip_decode' => (int)sprintf('%u', ip2long($camera->ip ?: '0.0.0.0')),
                'ip_server' => $camera->server ?: '0.0.0.0',
                'ip_server_decode' => (int)sprintf('%u', ip2long($camera->server ?: '0.0.0.0')),
                'status_exploitation' => 10, #TODO по доки с их апи ничего не понятно
                'status' => self::getStatus($camera->status),
            ];
        }

        return $data;
    }

    public static function getType(bool $type): int
    {
        return $type ? VideoCamera::PTZ : VideoCamera::NOT_A_PTZ;
    }

    public static function getStatus(string $status): int
    {
        return array_flip(VideoCamera::$statuses)[$status];
    }
}
