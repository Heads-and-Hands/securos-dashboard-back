<?php
declare(strict_types=1);

namespace App\Dashboard\Export;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use App\Dashboard\Reports\Reports;

class ExportToHtml implements Contracts\ExportReportInterface
{
    private $data;

    public function parseData(ExportReportData $data)
    {
        $this->data = $data;

        $reportSettings = $this->generateReportSettings();
        $dataToShow = $this->generateDataToShow();

        Storage::disk('reports')
            ->put('index.html', View::make('html.reports', [
                'reportSettings' => $reportSettings,
                'dataToShow' => $dataToShow,
                'lang' => App::currentLocale()
                ]));

        $zip_file = 'html.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $path = storage_path('reports-template');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();
                $relativePath = substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }

    private function generateReportSettings() : array
    {
        $reportSettings = [
            'countCameras' => count($this->data->reportParams->videoCameras),
            'cameras' => [],
            'period' => [
                'dateFrom' => $this->formatDateTime($this->data->reportParams->period->startDateTime),
                'dateTo' => $this->formatDateTime($this->data->reportParams->period->endDateTime)
            ],
            'dateReport' => $this->formatDateTime(Carbon::now()),
            'operator' => $this->data->userName
        ];

        foreach ($this->data->reportParams->videoCameras as $videoCamera) {
            $reportSettings['cameras'] []= [
                'name' => $videoCamera->name
            ];
        }

        return $reportSettings;
    }

    private function generateDataToShow()
    {
        return $this->data->reports;
    }

    private function formatDateTime(CarbonInterface $dateTime) : string
    {
        return $dateTime->toIso8601String();
    }
}
