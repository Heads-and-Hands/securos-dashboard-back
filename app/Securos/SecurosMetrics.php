<?php
declare(strict_types=1);

namespace App\Securos;


use Carbon\Carbon;

class SecurosMetrics extends BaseRequest
{
    protected const METRICS_URL = 'api/v1/metrics';
    protected const DATE_FORMAT = 'Ymd\THis';

    public static function getMetrics(
        string $tag,
        array $cameraIds,
        Carbon $startDateTime,
        Carbon $endDateTime)
    {
        $params = [
            'tag' => $tag,
            'cams' => implode(",", $cameraIds),
            'start' => self::formatDateTimeInput($startDateTime),
            'end' => self::formatDateTimeInput($endDateTime)
        ];
        $data = parent::get(self::METRICS_URL, $params);
        return json_decode($data);
        //return self::formatMetricsOutput($metrics);
    }

    private static function formatDateTimeInput(Carbon $dateTime): string
    {
        return $dateTime->format(self::DATE_FORMAT);
    }

    /*
    protected static function formatMetricsOutput($metrics): array
    {
        return $metrics;
    }*/

}
