<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;

use App\Dashboard\Reports\BaseReport;
use App\Dashboard\Reports\Reports;

class TotalTimeReport extends BaseReport
{
    public function getResult(array $data = []) : string
    {
        $totalValue = 0;
        foreach ($data as $intervalValue) {
            $totalValue += $intervalValue->value;
        }
        return $this->formatTimeValue($totalValue);
    }
}
