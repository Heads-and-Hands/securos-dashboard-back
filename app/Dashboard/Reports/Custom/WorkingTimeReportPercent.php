<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;


use App\Dashboard\Reports\ReportIntervalValue;
use App\Dashboard\Reports\BaseReport;
use App\Dashboard\Reports\Reports;

class WorkingTimeReportPercent extends BaseReport
{
    /**
     * @throws \Exception
     */
    public function getResult(array $availableTimeValues = [], array $problemStreamTimeValues = []) : array
    {
        $intervals = [];
        $availableTimeSum = 0;
        $workingTimeSum = 0;

        for ($i = 0; $i < $this->getPeriodIntervalCount(); $i++) {
            if ($availableTimeValues[$i]->value == 0) {
                $workingTimePercent = 0;
            }
            else {
                $workingTime = ($availableTimeValues[$i]->value - $problemStreamTimeValues[$i]->value);
                if ($workingTime < 0) throw new \Exception('available time should not be less than problem time');
                $workingTimePercent = 100 * $workingTime / $availableTimeValues[$i]->value;
                $workingTimeSum += $workingTime;
                $availableTimeSum += $availableTimeValues[$i]->value;
            }

            $intervals []= [
                Reports::KEY_START => $this->params->period->intervals[$i]->start->copy(),
                Reports::KEY_END => $this->params->period->intervals[$i]->end->copy(),
                Reports::KEY_VALUE => self::formatPercentValue($workingTimePercent)
            ];
        }

        if ($availableTimeSum == 0) {
            $totalValue = 0;
        }
        else {
            $totalValue = 100 * $workingTimeSum / $availableTimeSum;
        }

        return [
            Reports::KEY_INTERVALS => $intervals,
            Reports::KEY_TOTAL_VALUE => self::formatPercentValue($totalValue),
            Reports::KEY_TIME_UNIT => $this->getTimeUnit()
        ];
    }
}
