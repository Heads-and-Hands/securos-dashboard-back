<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Report;

use App\Dashboard\Reports\BaseReport;

class HourCountReport extends BaseReport
{
    public function getResult()
    {
        return
            ceil((
                $this->params->endDateTime->getTimestamp() -
                $this->params->startDateTime->getTimestamp()
            ) / 3600)
            * count($this->params->videoCameras);
    }
}
