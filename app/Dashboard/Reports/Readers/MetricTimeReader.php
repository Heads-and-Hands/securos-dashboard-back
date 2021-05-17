<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Readers;


use App\Dashboard\Reports\ReportIntervalValue;
use App\Dashboard\Reports\ReportParams;
use App\Securos\SecurosMetrics;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MetricTimeReader
{
    private array $data = [];
    private int $tag;

    public function __construct(int $tag)
    {
        $this->tag = $tag;
    }

    public function readData(ReportParams $params)
    {
        $this->data = [];
        foreach ($params->period->intervals as $interval) {
            $response = SecurosMetrics::getMetrics(
                $this->tag,
                $params->workingVideoCameraIds,
                $interval->start,
                $interval->end);
            if (isset($response->status) && $response->status > 300) {
                throw new HttpException($response->status, $response->message);
            }
            $valueSum = 0;
            foreach ($response->values[0] as $key => $value) {
                if (!in_array($key, ['start', 'end'])) {
                    $valueSum += intval($value);
                }
            }
            $this->data []= new ReportIntervalValue($interval->start, $interval->end, $valueSum);
        }
    }

    public function getResult() : array
    {
        return $this->data;
    }

}
