<?php
declare(strict_types=1);

namespace App\Dashboard\Export\Exports;

use App\Dashboard\Export\ExportReportData;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection
{
    private ExportReportData $data;

    private const DATETIME_FORMAT = 'd.m.Y H:i';

    public function __construct(ExportReportData $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $output = [];

        $output []= ['Количество камер: ' . count($this->data->reportParams->videoCameras)];
        $periodStr =
            self::formatDateTime($this->data->reportParams->period->startDateTime) . ' - ' .
            self::formatDateTime($this->data->reportParams->period->endDateTime);
        $output []= ['Период формирования отчета: ' . $periodStr];
        $output []= ['Дата и время формирования отчета: ' . self::formatDateTime(Carbon::now())];
        $output []= ['Имя оператора:' . $this->data->userName];

        /*
        $data = [
            [1, 2, 3],
            [4, 5, 6]
        ];
        */

        return new Collection($output);
    }

    private static function formatDateTime(CarbonInterface $dateTime) : string
    {
        // Перевести во временную зону пользователя, отфоматировать в виде строки
        return '__.__.____ __:__';
    }

}
