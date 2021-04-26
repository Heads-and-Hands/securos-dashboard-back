<?php

namespace App\Jobs;

use App\Models\ApiV1\VideoCamera;
use App\Models\Common\JobCheck;
use App\Securos\SecurosCameras;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SecurosCamerasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $checkJob = new JobCheck();
        $checkJob->name = 'SecurosCamerasJob';
        $checkJob->save();
        $this->applyChanges();
        $checkJob->done = true;
        $checkJob->save();
    }

    private function applyChanges()
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
