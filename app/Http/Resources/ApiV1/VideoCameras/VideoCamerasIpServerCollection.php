<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Http\Resources\ApiV1\BaseResourceCollection;
use Illuminate\Database\Eloquent\Collection;

class VideoCamerasIpServerCollection extends BaseResourceCollection
{
    public $collection = VideoCameraIpServerResource::class;

    public function toResponse($request)
    {
        $data = $this->resolve($request);

        if ($data instanceof Collection) {
            $data = $data->all();
        }

        $paginated = $this->resource->toArray();

        $response = [];
        foreach ($data['list'] as $list) {
            $response['list'][] = $list->ip_server;
        }

        return array_merge(
            $response,
            [
                'pagination' => [
                    'total'  => $paginated['total'] ?? null,
                    'limit'  => $paginated['limit'] ?? null,
                    'offset' => $paginated['offset'] ?? null,
                ],
            ],
            $this->with($request),
            $this->additional
        );
    }
}
