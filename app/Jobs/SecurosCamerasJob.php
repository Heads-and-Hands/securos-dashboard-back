<?php

namespace App\Jobs;

use App\Models\ApiV1\VideoCamera;
use App\Models\Common\JobCheck;
use App\Securos\SecurosCameras;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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

        VideoCamera::query()->upsert(SecurosCameras::getCameras(), ['id'],
            ['name', 'ip', 'type', 'ip_decode', 'ip_server', 'ip_server_decode',
                'status_exploitation', 'passport', 'status', 'approval_at', 'creation_at']);

        $checkJob->done = true;
        $checkJob->save();
    }
}
