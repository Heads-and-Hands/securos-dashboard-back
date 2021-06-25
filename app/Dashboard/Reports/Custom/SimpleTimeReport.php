<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;

use App\Dashboard\Reports\BaseReport;
use App\Dashboard\Reports\Reports;

class SimpleTimeReport extends  BaseReport
{
    public function getResult(array $data = []) : array
    {
        $intervals = [];
        $totalValue = 0;
        foreach ($data as $intervalValue) {
            $totalValue += $intervalValue->value;
            $intervals []= [
                Reports::KEY_START => $intervalValue->start->copy(),
                Reports::KEY_END => $intervalValue->end->copy(),
                Reports::KEY_VALUE => self::formatTimeValue($intervalValue->value)
            ];
        }
        return [
            Reports::KEY_INTERVALS => $intervals,
            Reports::KEY_TOTAL_VALUE => self::formatTimeValue($totalValue),
            Reports::KEY_TIME_UNIT => $this->getTimeUnit()
        ];
    }
}
