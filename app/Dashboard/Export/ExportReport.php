<?php
declare(strict_types=1);

namespace App\Dashboard\Export;

use App\Dashboard\Export\Contracts\ExportReportInterface;

class ExportReport
{
    protected ExportReportInterface $exportReport;
    protected ExportReportData $exportReportData;

    public function __construct(ExportReportInterface $exportReport, ExportReportData $exportReportData)
    {
        $this->exportReport = $exportReport;
        $this->exportReportData = $exportReportData;
    }

    public function generateDocument()
    {
        return $this->exportReport->parseData($this->exportReportData);
    }
}
