<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Models\ApiV1\VideoCamera;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoCamerasShortResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var $this VideoCamera */
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
