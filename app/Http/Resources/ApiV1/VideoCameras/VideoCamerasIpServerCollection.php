<?php

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Http\Resources\ApiV1\BaseResource;

class VideoCamerasIpServerCollection extends BaseResource
{
    public $collection = VideoCameraIpServerResource::class;
}
