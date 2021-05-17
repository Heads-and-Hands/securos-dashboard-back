<?php
declare(strict_types=1);

namespace App\Dashboard\Export\Exports;

use App\Dashboard\Export\ExportReportData;
use App\Dashboard\Reports\ReportPeriod;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Dashboard\Reports\Reports;
use Illuminate\Support\Facades\App;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReportsExport implements FromCollection, WithColumnWidths
{
    private ExportReportData $data;

    public function __construct(ExportReportData $data)
    {
        $this->data = $data;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18,
            'B' => 15,
        ];
    }

    public function collection() : Collection
    {
        $output = [];

        $output []= [__('reports.camera_count', [
            'count' => count($this->data->reportParams->videoCameras)])];
        $output []= [__('reports.cameras', [
            'camera_list' => $this->data->reportParams->videoCameras->implode('name', ', ')])];
        $output []= [__('reports.period', [
            'start' => $this->formatDateTime($this->data->reportParams->period->startDateTime),
            'end' => $this->formatDateTime($this->data->reportParams->period->endDateTime)])];
        $output []= [__('reports.report_generation_datetime', [
            'datetime' => $this->formatDateTime(Carbon::now())])];
        $output []= [__('reports.operator_name', ['name' => $this->data->userName])];
        $output []= [''];

        $output []= [
            __('reports.report_total_time', [
                'value' => $this->formatTimeValue($this->data->reports[Reports::REPORT_TOTAL_TIME])])];
        $output []= [''];

        $output []= [
            __('reports.report_not_working_camera_count', [
                'value' => $this->data->reports[Reports::REPORT_NOT_WORKING_CAMERA_COUNT]])];
        $output []= [''];

        // Если нет работающих камер, формировать остальные отчеты не имеет смысла
        if (count($this->data->reportParams->workingVideoCameraIds) == 0) {
            return new Collection($output);
        }

        $output [] = [__('reports.report_title_available_time')];
        $output = array_merge(
            $output, $this->generateTimeIntervalReport($this->data->reports[Reports::REPORT_WORKING_TIME]));
        $output [] = [''];

        $output [] = [__('reports.report_title_available_time_percent')];
        $output = array_merge(
            $output, $this->generatePercentIntervalReport(
            $this->data->reports[Reports::REPORT_WORKING_TIME_PERCENT]));
        $output [] = [''];

        $output [] = [__('reports.report_title_problem_time')];
        $output = array_merge(
            $output, $this->generateTimeIntervalReport($this->data->reports[Reports::REPORT_PROBLEM_TIME]));
        $output [] = [''];

        return new Collection($output);
    }

    private function generateTimeIntervalReport(array $report) : array
    {
        $output = [];
        $output []= [__('reports.total_value_time', [
            'value' => $this->formatTimeValue($report[Reports::KEY_TOTAL_VALUE])])];
        $output []= [__('reports.title_datetime') ,  __('reports.title_value_time')];
        foreach($report[Reports::KEY_INTERVALS] as $interval) {
            $output []= [
                $this->formatIntervalDateTime($interval[Reports::KEY_START]),
                $this->formatTimeValue($interval[Reports::KEY_VALUE])
            ];
        }
        return $output;
    }

    private function generatePercentIntervalReport(array $report) : array
    {
        $output = [];
        $output []= [__('reports.total_value_percent', [
            'value' => $this->formatPercentValue($report[Reports::KEY_TOTAL_VALUE])])];
        $output []= [__('reports.title_datetime') ,  __('reports.title_value_percent')];
        foreach($report[Reports::KEY_INTERVALS] as $interval) {
            $output []= [
                $this->formatIntervalDateTime($interval[Reports::KEY_START]),
                $this->formatPercentValue($interval[Reports::KEY_VALUE])
            ];
        }
        return $output;
    }

    private function formatDateTime(CarbonInterface $dateTime) : string
    {
        return $dateTime->copy()
            ->addMinutes($this->data->reportParams->period->dateTimeOffset)
            ->format(__('reports.datetime_format'));
    }

    private function formatIntervalDateTime(CarbonInterface $dateTime) : string
    {
        if ($this->data->reportParams->period->intervalType == ReportPeriod::INTERVAL_HOUR) {
            $format = __('reports.datetime_format');
        }
        else {
            $format = __('reports.date_format');
        }
        return $dateTime->copy()
            ->addMinutes($this->data->reportParams->period->dateTimeOffset)
            ->format($format);
    }

    private function formatTimeValue(string $value) : string
    {
        $parts = explode(':', $value);
        return __('reports.value_time', [
            'hours' => $parts[0],
            'minutes' => $parts[1]
        ]);
    }

    private function formatPercentValue(string $value) : string
    {
        return $value . '%';
    }

}
