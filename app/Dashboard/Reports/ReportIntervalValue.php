<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;

use Carbon\CarbonInterface;

class ReportIntervalValue
{
    public CarbonInterface $start;
    public CarbonInterface $end;
    public int $value;

    public function __construct(CarbonInterface $start, CarbonInterface $end, int $value)
    {
        $this->start = $start->copy();
        $this->end = $end->copy();
        $this->value = $value;
    }

}
