<?php

namespace App\Models\ApiV1\Filter;

use App\Models\QueryFilter;

class VideoCameraIpServerFilter extends QueryFilter
{
    public function q($value): void
    {
        $this->builder->where('ip_server', 'ilike', '%' . trim($value) . '%');
    }
}
