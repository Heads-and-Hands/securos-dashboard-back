<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\Passports;

use App\Models\ApiV1\VideoCamera;
use App\Securos\SecurosCameraPhoto;
use Illuminate\Http\Resources\Json\JsonResource;

class PassportsResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var VideoCamera $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'ip' => $this->ip,
            'ipServer' => $this->ip_server,
            'status' => $this->status,
            'passport' => is_null($this->passport) ? null : [
                'width' => $this->width,
                'height' => $this->height,
                'fps' => $this->fps,
                'kbps' => $this->kbps,
            ],
            'statusExploitation' => $this->status_exploitation,
            'approvalAt' => $this->approval_at,
            'creationAt' => $this->creation_at,
            'update_time' => $this->update_time,
            'image' => $this->image,
        ];
    }
}
