<?php
declare(strict_types=1);

namespace App\Dashboard\Export;

use App\Dashboard\Export\Contracts\ExportReportInterface;

class ExportToPdf implements ExportReportInterface
{
    public function parseData($data)
    {
        dd($data);
    }
}
