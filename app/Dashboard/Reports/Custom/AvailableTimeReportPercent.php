<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;


use App\Dashboard\Reports\ReportIntervalValue;
use App\Dashboard\Reports\BaseReport;
use App\Dashboard\Reports\Reports;

class AvailableTimeReportPercent extends BaseReport
{
    public function getResult(array $data = []) : array
    {
        // Если в списке нет работающих камер, при формировании отчета возникнет деление на нуль
        if ($this->getWorkingCameraCount() == 0) {
            throw new \Exception('Cannot generate report: no working camera selected');
        }

        $intervals = [];
        $totalValue = 0;
        foreach ($data as $intervalValue) {
            $availableTimePercent = $this->calculateAvailableTimePercent($intervalValue);
            $totalValue += $availableTimePercent;
            $intervals []= [
                Reports::KEY_START => $intervalValue->start->copy(),
                Reports::KEY_END => $intervalValue->end->copy(),
                Reports::KEY_VALUE => self::formatPercentValue($availableTimePercent)
            ];
        }
        return [
            Reports::KEY_INTERVALS => $intervals,
            Reports::KEY_TOTAL_VALUE => self::formatPercentValue($totalValue / count($data)),
            Reports::KEY_TIME_UNIT => $this->getTimeUnit()
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
