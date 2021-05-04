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

    protected function formatTimeValue(int $seconds) : string
    {
        #TODO разбить на часы и минуты через целочисленное деление
        //$interval = CarbonInterval::seconds($seconds);
        //return $seconds . ' -> ' . $interval . '| ' . $interval->format("%h:%i:%s");
        return '__:__';
    }

    protected function formatPercentValue(float $value) : string
    {
        return number_format($value, 1, '.', '');
    }

}
