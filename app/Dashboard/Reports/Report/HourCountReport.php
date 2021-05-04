<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Report;

use App\Dashboard\Reports\BaseReport;

class HourCountReport extends BaseReport
{
    public function getResult() : string
    {
        return
            $this->formatTimeValue(
                $this->params->period->endDateTime->diffInSeconds($this->params->period->startDateTime) *
                $this->getWorkingCameraCount());
    }
}
