<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;

use App\Dashboard\Reports\BaseReport;
use App\Dashboard\Reports\ReportIntervalValue;
use App\Dashboard\Reports\Reports;

class WorkingTimeReport extends BaseReport
{
    /**
     * @throws \Exception
     */
    public function getResult(array $availableTimeValues = [], array $problemStreamTimeValues = []) : array
    {
        $intervals = [];
        $totalValue = 0;

        for ($i = 0; $i < $this->getPeriodIntervalCount(); $i++) {
            $workingTime =
                $availableTimeValues[$i]->value - $problemStreamTimeValues[$i]->value;
            if ($workingTime < 0) throw new \Exception('available time should not be less than problem time');
            $totalValue += $workingTime;
            $intervals []= [
                Reports::KEY_START => $this->params->period->intervals[$i]->start->copy(),
                Reports::KEY_END => $this->params->period->intervals[$i]->end->copy(),
                Reports::KEY_VALUE => self::formatTimeValue($workingTime)
            ];
        }
        return [
            Reports::KEY_INTERVALS => $intervals,
            Reports::KEY_TOTAL_VALUE => self::formatTimeValue($totalValue),
            Reports::KEY_TIME_UNIT => $this->getTimeUnit()
        ];
    }
}
