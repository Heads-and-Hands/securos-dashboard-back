<?php

namespace App\Http\Resources\ApiV1\VideoCameras;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoCamerasStatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
