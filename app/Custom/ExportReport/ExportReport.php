<?php
declare(strict_types=1);

namespace App\Custom\ExportReport;

use App\Custom\Contracts\ExportReportInterface;

class ExportReport
{
    protected ExportReportInterface $exportReport;
    protected $videoCameraCollection;

    public function __construct(ExportReportInterface $exportReport, $videoCameraCollection)
    {
        $this->exportReport = $exportReport;
        $this->videoCameraCollection = $videoCameraCollection;
    }

    public function generateDocument()
    {
        return $this->exportReport->parseData($this->videoCameraCollection);
    }
}
