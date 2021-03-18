<?php
declare(strict_types=1);

namespace App\Custom\Contracts;

interface ExportReportInterface
{
    public function parseDate($data);
}
