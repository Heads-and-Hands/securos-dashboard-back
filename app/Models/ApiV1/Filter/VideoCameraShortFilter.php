<?php
declare(strict_types=1);

namespace App\Models\ApiV1\Filter;

use App\Http\Requests\ApiV1\VideoCamera\Filter\VideoCameraFilterRequest;
use App\Models\QueryFilter;

class VideoCameraShortFilter extends QueryFilter
{
    public function __construct(VideoCameraFilterRequest $request)
    {
        parent::__construct($request);
    }

    public function q($value): void
    {
        $this->builder->where('name', 'ilike', '%' . trim($value) . '%');
    }
}
