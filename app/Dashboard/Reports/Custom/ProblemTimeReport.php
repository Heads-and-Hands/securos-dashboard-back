<?php
declare(strict_types=1);

namespace App\Dashboard\Reports\Custom;


use App\Dashboard\Reports\BaseReport;

class ProblemTimeReport extends  BaseReport
{
    public function getResult(array $data = []) : array
    {
        $intervals = [];
        $totalValue = 0;
        foreach ($data as $intervalValue) {
            $totalValue += $intervalValue->value;
            $intervals []= [
                'start' => $intervalValue->start->copy(),
                'end' => $intervalValue->end->copy(),
                'value' => self::formatTimeValue($intervalValue->value)
            ];
        }
        return [
            'intervals' => $intervals,
            'totalValue' => self::formatTimeValue($totalValue)
        ];
    }
}
