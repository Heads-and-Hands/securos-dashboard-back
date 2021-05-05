<?php


namespace App\Dashboard\Export;


use App\Dashboard\Reports\ReportParams;

class ExportReportData
{
    public ReportParams $reportParams;
    public string $userName;
    public array $reports;
}
