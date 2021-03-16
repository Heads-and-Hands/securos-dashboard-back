<?php

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Models\ApiV1\VideoCamera;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoCameraIpServerResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var $this VideoCamera */
        return [
            'ipServer' => $this->ip_server,
        ];
    }
}
