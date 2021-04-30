<?php
declare(strict_types=1);

namespace App\Custom\ExportReport;

use App\Custom\Contracts\ExportReportInterface;

class ExportToPdf implements ExportReportInterface
{
    public function parseData($data)
    {
        dd($data);
    }
}
