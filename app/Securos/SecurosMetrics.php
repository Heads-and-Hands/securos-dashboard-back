<?php
declare(strict_types=1);

namespace App\Securos;


use Carbon\Carbon;

class SecurosMetrics extends BaseRequest
{
    protected const METRICS_URL = 'api/v1/metrics';
    protected const DATE_FORMAT = 'Ymd\THis';

    public const TAG_AVAILABLE = 10;
    public const TAG_PROBLEM = 20;
    public const TAG_PROBLEM_STREAM = 30;
    public const TAG_PROBLEM_STREAM_FPS = 40;
    public const TAG_PROBLEM_STREAM_BPS = 50;
    public const TAG_PROBLEM_STREAM_RES = 60;

    private static array $tags = [
        self::TAG_AVAILABLE  => 'available',
        self::TAG_PROBLEM => 'problem',
        self::TAG_PROBLEM_STREAM => 'problem-stream',
        self::TAG_PROBLEM_STREAM_FPS => 'problem-stream-fps',
        self::TAG_PROBLEM_STREAM_BPS => 'problem-stream-bps',
        self::TAG_PROBLEM_STREAM_RES => 'problem-stream-res',
    ];

    public static function getMetrics(
        int $tag,
        array $cameraIds,
        Carbon $startDateTime,
        Carbon $endDateTime)
    {
        $params = [
            'tag' => static::$tags[$tag],
            'cams' => implode(",", $cameraIds),
            'start' => self::formatDateTimeInput($startDateTime),
            'end' => self::formatDateTimeInput($endDateTime)
        ];
        $data = parent::get(self::METRICS_URL, $params);
        return json_decode($data);
    }

    private static function formatDateTimeInput(Carbon $dateTime): string
    {
        return $dateTime->format(self::DATE_FORMAT);
    }
}
