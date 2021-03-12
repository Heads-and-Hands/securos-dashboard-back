<?php
declare(strict_types=1);

namespace App\Models\ApiV1;

use App\Http\Resources\ApiV1\VideoCameras\VideoCamerasStatisticResource;
use App\Models\ApiV1\Filter\{VideoCameraFilter, VideoCameraShortFilter};
use App\Models\Common\VideoCamera as VC;
use Illuminate\{Database\Eloquent\Builder, Support\Facades\DB};

class VideoCamera extends VC
{
    public static function getStatistics(): array
    {
        $data = DB::table('video_cameras')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->map(fn($item) => [
                'status' => self::$statuses[$item->status],
                'total' => $item->total,
            ])->toArray();

        $response['value'] = VideoCamerasStatisticResource::collection($data);
        $response['countAllCameras'] = self::query()->count();

        return $response;
    }

    public function scopeFilter(Builder $query, VideoCameraFilter $filter): void
    {
        $filter->apply($query);
    }

    public function scopeShortFilter(Builder $query, VideoCameraShortFilter $filter): void
    {
        $filter->apply($query);
    }
}
