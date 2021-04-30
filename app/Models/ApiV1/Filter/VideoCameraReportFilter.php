<?php
declare(strict_types=1);

namespace App\Models\ApiV1\Filter;

use App\Http\Requests\ApiV1\VideoCamera\Filter\VideoCameraReportFilterRequest;
use App\Models\Common\VideoCamera;
use App\Models\QueryFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class VideoCameraReportFilter extends QueryFilter
{
    public function __construct(VideoCameraReportFilterRequest $request)
    {
        parent::__construct($request);
    }

    #TODO Убрать
    // Нельзя отфильтровывать на этой стадии, так как в одном отчете требуются в том числе камеры не в эксплатации
    /*
    public function apply(Builder $builder)
    {
        parent::apply($builder);
        $this->builder->whereNotIn('status', [VideoCamera::NOT_IN_OPERATION, VideoCamera::UNKNOWN]);
    }*/

    public function ids($value): void
    {
        if ($value) {
            $value = explode(',', $value);
            $this->builder->whereIn('id', $value);
        }
    }

    public function notIds($value): void
    {
        if ($value) {
            $value = explode(',', $value);
            $this->builder->whereNotIn('id', $value);
        }
    }

    #TODO Удалить в итоговой версии
    /*
    public function rangeOfDate($value): void
    {
        if ($value) {
            $value = explode('-', $value);
            $dateStart = Carbon::parse($value[0]);
            $dateEnd = Carbon::parse($value[1]);
            $this->builder->whereBetween('creation_at', [$dateStart, $dateEnd]);
        }
    }*/
}
