<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\Passports;

use App\Http\Resources\ApiV1\BaseResource;
use App\Models\ApiV1\VideoCamera;

class UnverifiedPassportResource extends BaseResource
{
    public function toArray($request)
    {
        /** @var VideoCamera $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
