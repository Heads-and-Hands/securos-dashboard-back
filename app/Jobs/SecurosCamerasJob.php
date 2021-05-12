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
use App\Dashboard\Cameras\Cameras;

class SecurosCamerasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Cameras::updateCameras();
    }
}
