<?php
declare(strict_types=1);

namespace App\Http\Resources\ApiV1\VideoCameras;

use App\Http\Resources\ApiV1\BaseResourceCollection;
use App\Models\ApiV1\VideoCamera;
use Illuminate\Database\Eloquent\Collection;

class VideoCamerasCollection extends BaseResourceCollection
{
    public $collects = VideoCameraResource::class;

    public function toResponse($request)
    {
        $data = $this->resolve($request);
        if ($data instanceof Collection) {
            $data = $data->all();
        }

        $paginated = $this->resource->toArray();

        return array_merge(
            $data,
            [
                'statistic' => VideoCamera::getStatistics(),
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
