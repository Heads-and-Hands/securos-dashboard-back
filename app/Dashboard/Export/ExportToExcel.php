<?php
declare(strict_types=1);

namespace App\Dashboard\Export;

use App\Dashboard\Export\Contracts\ExportReportInterface;
use Maatwebsite\Excel\Facades\Excel;
use App\Dashboard\Export\Exports\ReportsExport;

class ExportToExcel implements ExportReportInterface
{
    public function parseData(ExportReportData $data)
    {
        return Excel::download(new ReportsExport($data), 'reports.xlsx');
    }
}
