<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;

use App\Dashboard\Reports\BaseReport;
use App\Dashboard\Reports\ReportIntervalValue;

class AvailableTimeReport extends BaseReport
{
    public function getResult(array $data = []) : array
    {
        $intervals = [];
        $totalValue = 0;
        foreach ($data as $intervalValue) {
            $availableTime = $this->calculateAvailableTime($intervalValue);
            $totalValue += $availableTime;
            $intervals []= [
                'start' => $intervalValue->start->copy(),
                'end' => $intervalValue->end->copy(),
                'value' => self::formatTimeValue($availableTime)
            ];
        }
        return [
            'intervals' => $intervals,
            'totalValue' => self::formatTimeValue($totalValue)
        ];
    }

    protected function calculateAvailableTime(ReportIntervalValue $intervalValue) : int
    {
        $periodLength = $intervalValue->end->diffInSeconds($intervalValue->start);
        $totalTime = $periodLength * $this->getWorkingCameraCount();
        return $totalTime - $intervalValue->value;
    }
}
