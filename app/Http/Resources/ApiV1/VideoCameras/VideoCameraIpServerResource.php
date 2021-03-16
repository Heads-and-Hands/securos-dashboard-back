<?php

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Http\Resources\ApiV1\BaseResource;
use App\Models\ApiV1\VideoCamera;

class VideoCameraIpServerResource extends BaseResource
{
    public function toArray($request): array
    {
        /** @var VideoCamera $this */
        return [
            'ipServer' => $this->ip_server,
        ];
    }
}
