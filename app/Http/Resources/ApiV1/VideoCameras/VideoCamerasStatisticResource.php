<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\VideoCameras;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoCamerasStatisticResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
