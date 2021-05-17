<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;

use App\Dashboard\Reports\BaseReport;
use App\Dashboard\Reports\ReportIntervalValue;
use App\Dashboard\Reports\Reports;

class WorkingTimeReport extends BaseReport
{
    public function getResult(array $data = []) : array
    {
        $intervals = [];
        $totalValue = 0;
        foreach ($data as $intervalValue) {
            $availableTime = $this->calculateAvailableTime($intervalValue);
            $totalValue += $availableTime;
            $intervals []= [
                Reports::KEY_START => $intervalValue->start->copy(),
                Reports::KEY_END => $intervalValue->end->copy(),
                Reports::KEY_VALUE => self::formatTimeValue($availableTime)
            ];
        }
        return [
            Reports::KEY_INTERVALS => $intervals,
            Reports::KEY_TOTAL_VALUE => self::formatTimeValue($totalValue),
            Reports::KEY_TIME_UNIT => $this->getTimeUnit()
        ];
    }

    protected function calculateAvailableTime(ReportIntervalValue $intervalValue) : int
    {
        $periodLength = $intervalValue->end->diffInSeconds($intervalValue->start);
        $totalTime = $periodLength * $this->getWorkingCameraCount();
        return $totalTime - $intervalValue->value;
    }
}
