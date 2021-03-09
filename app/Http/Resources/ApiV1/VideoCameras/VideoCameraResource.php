<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Http\Resources\ApiV1\BaseResource;
use App\Models\ApiV1\VideoCamera;

class VideoCameraResource extends BaseResource
{
    /**
     * @return array
     * @var $this VideoCamera
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'ip' => $this->ip,
            'ipServer' => $this->ip_server,
            'status' => $this->status,
            'passport' => $this->passport,
        ];
    }
}