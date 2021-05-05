<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;

use Carbon\CarbonInterval;

abstract class BaseReport
{
    protected ReportParams $params;

    public function __construct(ReportParams $params)
    {
        $this->params = $params;
    }

    public abstract function getResult();

    protected function getWorkingCameraCount() : int
    {
        return count($this->params->workingVideoCameraIds);
    }

    protected static function formatTimeValue(int $seconds) : string
    {
        $hours = intdiv($seconds, 3600);
        $minutes = round(($seconds % 3600) / 60);
        return $hours . ':' . $minutes;
    }

    protected static function formatPercentValue(float $value) : string
    {
        return number_format($value, 1, '.', '');
    }

}
