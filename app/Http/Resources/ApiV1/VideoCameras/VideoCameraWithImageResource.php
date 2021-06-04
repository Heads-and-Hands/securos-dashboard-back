<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Models\ApiV1\VideoCamera;

class VideoCameraWithImageResource extends VideoCameraResource
{
    public function toArray($request): array
    {
        /** @var VideoCamera $this */
        return [
            'data' => array_merge(parent::toArray($request), ['image' => $this->image])
        ];
    }
}
