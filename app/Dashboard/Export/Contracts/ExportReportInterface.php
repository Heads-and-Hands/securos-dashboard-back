<?php
declare(strict_types=1);

namespace App\Dashboard\Export\Contracts;

use App\Dashboard\Export\ExportReportData;

interface ExportReportInterface
{
    public function parseData(ExportReportData $data);
}
