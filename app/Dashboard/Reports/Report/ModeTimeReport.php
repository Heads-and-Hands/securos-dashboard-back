<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Report;

use App\Dashboard\Reports\ReportIntervalValue;
use App\Securos\SecurosMetrics;
use App\Dashboard\Reports\BaseReport;

class ModeTimeReport extends BaseReport
{
    public const REPORT_TYPE_PROBLEM_TIME = 10;
    public const REPORT_TYPE_AVAILABLE_TIME = 20;
    public const REPORT_TYPE_AVAILABLE_PERCENT = 30;

    private array $results = [];

    public function readData()
    {
        $this->results = [];
        foreach ($this->params->period->intervals as $interval) {
            $response = SecurosMetrics::getMetrics(
                SecurosMetrics::TAG_PROBLEM_STREAM,
                $this->params->workingVideoCameraIds,
                $interval->start,
                $interval->end);
            if (isset($response->status) && $response->status > 300) {
                throw new \HttpException($response->message, $response->status);
            }
            $valueSum = 0;
            foreach ($response->values[0] as $key => $value) {
                if (!in_array($key, ['start', 'end'])) {
                    $valueSum += intval($value);
                }
            }
            $this->results []= new ReportIntervalValue($interval->start, $interval->end, $valueSum);
        }
    }

    public function getResult(int $reportType = self::REPORT_TYPE_PROBLEM_TIME) : array
    {
        $data = [];
        foreach ($this->results as $intervalValue) {
            $data []= [
                'start' => $intervalValue->start->copy(),
                'end' => $intervalValue->end->copy(),
                'value' => $this->calculateVal($intervalValue, $reportType)
            ];
        }
        return $data;
    }

    private function calculateVal(ReportIntervalValue $intervalValue, int $reportType) : string
    {
        $periodLength = $intervalValue->end->diffInSeconds($intervalValue->start);
        $totalTime = $periodLength * $this->getWorkingCameraCount();
        $availableTime = $totalTime - $intervalValue->value;
        switch ($reportType) {
            case self::REPORT_TYPE_PROBLEM_TIME:
                return $this->formatTimeValue($intervalValue->value);
            case self::REPORT_TYPE_AVAILABLE_TIME:
                return $this->formatTimeValue($availableTime);
            case self::REPORT_TYPE_AVAILABLE_PERCENT:
            default:
                return $this->formatPercentValue(100 * $availableTime / $totalTime);
        }
    }
}
