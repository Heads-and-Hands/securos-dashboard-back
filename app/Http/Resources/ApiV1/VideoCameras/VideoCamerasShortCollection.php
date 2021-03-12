<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Http\Resources\ApiV1\BaseResourceCollection;

class VideoCamerasShortCollection extends BaseResourceCollection
{
    public $collects = VideoCamerasShortResource::class;
}
