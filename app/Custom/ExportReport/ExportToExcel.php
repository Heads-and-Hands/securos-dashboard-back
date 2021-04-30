<?php
declare(strict_types=1);

namespace App\Custom\ExportReport;

use App\Custom\Contracts\ExportReportInterface;
use App\Exports\VideoCameraExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportToExcel implements ExportReportInterface
{
    public function parseData($data)
    {
       return Excel::download(new VideoCameraExport($data), 'videoCamera.xlsx');
    }
}
