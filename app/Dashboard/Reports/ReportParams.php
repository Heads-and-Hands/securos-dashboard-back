<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;


use App\Models\Common\VideoCamera;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ReportParams
{
    public const INTERVAL_HOUR = 10;
    public const INTERVAL_DAY = 20;
    public const INTERVAL_WEEK = 30;
    public const INTERVAL_MONTH = 40;
    public const INTERVAL_QUARTER = 50;
    public const INTERVAL_YEAR = 60;

    public Collection $videoCameras;
    public $workingVideoCameraIds = [];
    public Carbon $startDateTime;
    public Carbon $endDateTime;
    // Сдвиг временной зоны пользователя относительно UTC+0 в минутах
    public int $dateTimeOffset;

    public int $intervalType;

    public function __construct(
        Collection $videoCameras,
        Carbon $startDateTime,
        Carbon $endDateTime,
        int $dateTimeOffset)
    {
        $this->videoCameras = $videoCameras;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->dateTimeOffset = $dateTimeOffset;

        foreach ($videoCameras as $videoCamera) {
            if (($videoCamera->status != VideoCamera::$statuses[VideoCamera::NOT_IN_OPERATION])
                && ($videoCamera->status != VideoCamera::$statuses[VideoCamera::UNKNOWN]))
            {
                $this->workingVideoCameraIds []= $videoCamera->id;
            }
        }
        $this->initIntervalType();
        $this->initIntervals();
    }

    private function initIntervalType()
    {
        if ($this->endDateTime->diffInHours($this->startDateTime) < 24) {
            $this->intervalType = self::INTERVAL_HOUR;
        }
        elseif ($this->endDateTime->diffInMonths() < 1) {
            $this->intervalType = self::INTERVAL_DAY;
        }
        elseif ($this->endDateTime->diffInMonths() < 6) {
            $this->intervalType = self::INTERVAL_WEEK;
        }
        elseif ($this->endDateTime->diffInYears() < 2) {
            $this->intervalType = self::INTERVAL_MONTH;
        }
        elseif ($this->endDateTime->diffInYears() < 5) {
            $this->intervalType = self::INTERVAL_QUARTER;
        }
        else {
            $this->intervalType = self::INTERVAL_YEAR;
        }
    }

    private function initIntervals()
    {
        $start = $this->offsetDateTime($this->startDateTime);
        $end = $this->offsetDateTime($this->endDateTime);

        $intervals = [];

        #TODO Разбивка периода на интервалы

        return $this->intervalsToUtc($intervals);
    }

    private function intervalsToUtc($intervals)
    {
        foreach ($intervals as $num => $interval) {
            $intervals[$num]['start'] =
                $this->offsetDateTime($interval['start'], -$this->dateTimeOffset);
            $intervals[$num]['end'] =
                $this->offsetDateTime($interval['end'], -$this->dateTimeOffset);
        }
        return $intervals;
    }

    private function offsetDateTime(Carbon $dateTime, ?int $offset = null) : Carbon
    {
        $offset = $offset ?? $this->dateTimeOffset;
        if ($offset > 0) {
            return $dateTime->addMinutes($this->dateTimeOffset);
        }
        else {
            return $dateTime->subMinutes($this->dateTimeOffset);
        }
    }
}
