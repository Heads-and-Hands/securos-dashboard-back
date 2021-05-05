<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;


use App\Dashboard\Reports\ReportIntervalValue;
use App\Dashboard\Reports\BaseReport;

class AvailableTimeReportPercent extends BaseReport
{
    public function getResult(array $data = []) : array
    {
        $intervals = [];
        $totalValue = 0;
        foreach ($data as $intervalValue) {
            $availableTimePercent = $this->calculateAvailableTimePercent($intervalValue);
            $totalValue += $availableTimePercent;
            $intervals []= [
                'start' => $intervalValue->start->copy(),
                'end' => $intervalValue->end->copy(),
                'value' => self::formatPercentValue($availableTimePercent)
            ];
        }
        return [
            'intervals' => $intervals,
            'totalValue' => self::formatPercentValue($totalValue / count($data))
        ];
    }

    protected function calculateAvailableTimePercent(ReportIntervalValue $intervalValue) : float
    {
        $periodLength = $intervalValue->end->diffInSeconds($intervalValue->start);
        $totalTime = $periodLength * $this->getWorkingCameraCount();
        $availableTime = $totalTime - $intervalValue->value;
        return 100 * $availableTime / $totalTime;
    }
}
