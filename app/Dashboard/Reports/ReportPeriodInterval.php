<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class ReportPeriodInterval
{
    public CarbonInterface $start;
    public CarbonInterface $end;

    public function __construct(CarbonInterface $start, CarbonInterface $end)
    {
        $this->start = $start->copy();
        $this->end = $end->copy();
    }
}
