<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;

use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;

class ReportPeriod
{
    public CarbonInterface $startDateTime;
    public CarbonInterface $endDateTime;
    // Сдвиг временной зоны пользователя относительно UTC в минутах
    public int $dateTimeOffset;

    public const INTERVAL_HOUR = 10;
    public const INTERVAL_DAY = 20;
    public const INTERVAL_WEEK = 30;
    public const INTERVAL_MONTH = 40;
    public const INTERVAL_QUARTER = 50;
    public const INTERVAL_YEAR = 60;

    public int $intervalType;
    public array $intervals = [];

    public function __construct(
        CarbonInterface $startDateTime,
        CarbonInterface $endDateTime,
        int $dateTimeOffset)
    {
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->dateTimeOffset = $dateTimeOffset;

        $this->initIntervalType();
        $this->initIntervals();
    }

    private function initIntervalType()
    {
        if ($this->endDateTime->diffInHours($this->startDateTime) < 24) {
            $this->intervalType = self::INTERVAL_HOUR;
        }
        elseif ($this->endDateTime->diffInMonths($this->startDateTime) < 1) {
            $this->intervalType = self::INTERVAL_DAY;
        }
        elseif ($this->endDateTime->diffInMonths($this->startDateTime) < 6) {
            $this->intervalType = self::INTERVAL_WEEK;
        }
        elseif ($this->endDateTime->diffInYears($this->startDateTime) < 2) {
            $this->intervalType = self::INTERVAL_MONTH;
        }
        elseif ($this->endDateTime->diffInYears($this->startDateTime) <= 5) {
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
        $intervals = $this->splitPeriod($start, $end);
        $this->intervals = $this->intervalsToUtc($intervals);
    }

    /*
     * Разбивает заданный период на интервалы, возвращая результат в виде массива.
     * Работает с датами во временной зоне пользователя
     * */
    private function splitPeriod(CarbonInterface $startDateTime, CarbonInterface $endDateTime) : array
    {
        $intervals = [];
        $nextPeriodBound = $this->getNextPeriodBound($startDateTime);
        $bounds = $this->getIntervalBounds($nextPeriodBound, $endDateTime);
        $periodStart = $startDateTime;
        foreach ($bounds as $bound)
        {
            $intervals []= new ReportPeriodInterval($periodStart, $bound);
            $periodStart = $bound->copy();
        }
        if ($periodStart->notEqualTo($endDateTime)) {
            $intervals [] = new ReportPeriodInterval($periodStart, $endDateTime);
        }
        return $intervals;
    }

    /*
     * Вычисляет ближайшую границу периода, следующую за заданной датой
     * */
    private function getNextPeriodBound(CarbonInterface $startDateTime) : CarbonInterface
    {
        switch ($this->intervalType) {
            case self::INTERVAL_HOUR:
                return $startDateTime->copy()->startOfHour()->addHour();
            case self::INTERVAL_DAY:
                return $startDateTime->copy()->startOfDay()->addDay();
            case self::INTERVAL_WEEK:
                return $startDateTime->copy()->startOfWeek()->addWeek();
            case self::INTERVAL_MONTH:
                return $startDateTime->copy()->startOfMonth()->addMonth();
            case self::INTERVAL_QUARTER:
                return $startDateTime->copy()->startOfQuarter()->addQuarter();
            case self::INTERVAL_YEAR:
            default:
                return $startDateTime->copy()->startOfYear()->addYear();
        }
    }

    /*
     * Возвращает границы интервалов для заданного диапазона
     * */
    private function getIntervalBounds(CarbonInterface $startDateTime, CarbonInterface $endDateTime) : CarbonPeriod
    {
        switch ($this->intervalType) {
            case self::INTERVAL_HOUR:
                return $startDateTime->hoursUntil($endDateTime);
            case self::INTERVAL_DAY:
                return $startDateTime->daysUntil($endDateTime);
            case self::INTERVAL_WEEK:
                return $startDateTime->weeksUntil($endDateTime);
            case self::INTERVAL_MONTH:
                return $startDateTime->monthsUntil($endDateTime);
            case self::INTERVAL_QUARTER:
                return $startDateTime->quartersUntil($endDateTime);
            case self::INTERVAL_YEAR:
            default:
                return $startDateTime->yearsUntil($endDateTime);
        }
    }

    /*
     * Переводит интервалы из временной зоны пользователя в UTC
     * */
    private function intervalsToUtc($intervals)
    {
        foreach ($intervals as $interval) {
            $interval->start =
                $this->offsetDateTime($interval->start, -$this->dateTimeOffset);
            $interval->end =
                $this->offsetDateTime($interval->end, -$this->dateTimeOffset);
        }
        return $intervals;
    }

    /*
     * Сдвигает время на заданное количество минут вперед (если используется положительное значение)
     * или назад (если инпользуется отрицательное). Если время сдвига не задано,
     * в качестве величины сдвига используется значение $this->dateTimeOffset
     * */
    private function offsetDateTime(CarbonInterface $dateTime, ?int $offset = null) : CarbonInterface
    {
        $offset = $offset ?? $this->dateTimeOffset;
        if ($offset > 0) {
            return $dateTime->copy()->addMinutes($this->dateTimeOffset);
        }
        else {
            return $dateTime->copy()->subMinutes($this->dateTimeOffset);
        }
    }

}
