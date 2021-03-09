<?php

namespace App\Http\Resources\ApiV1;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'list' => $this->collection
        ];
    }

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
