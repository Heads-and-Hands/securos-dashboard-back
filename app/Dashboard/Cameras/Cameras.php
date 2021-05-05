<?php


namespace App\Dashboard\Cameras;


use App\Models\ApiV1\VideoCamera;
use App\Securos\SecurosCameras;
use App\Models\Common\JobCheck;

class Cameras
{
    /*
     * Обновляет список камер из Securos API
     * Дублирует работу задания SecurosCameraJob, выполняя ее синхронно
     * */
    public static function updateCameras()
    {
        $checkJob = new JobCheck();
        $checkJob->name = 'SecurosCamerasJob';
        $checkJob->save();
        self::doUpdateCameras();
        $checkJob->done = true;
        $checkJob->save();
    }

    private static function doUpdateCameras()
    {
        $cameras = SecurosCameras::getCameras();
        $cameraIds = [];
        foreach ($cameras as $camera) {
            $cameraIds []= $camera['id'];
        }
        VideoCamera::whereNotIn('id', $cameraIds)->delete();
        VideoCamera::query()->upsert($cameras, ['id'],
            ['name', 'ip', 'type', 'ip_decode', 'ip_server', 'ip_server_decode',
                'status_exploitation', 'passport', 'status', 'approval_at', 'creation_at', 'approved', 'update_time']);
    }

}