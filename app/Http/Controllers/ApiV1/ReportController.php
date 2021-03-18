<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Custom\Contracts\ExportReportInterface;
use App\Custom\ExportReport\ExportReport;
use App\Http\Controllers\Controller;
use App\Models\ApiV1\Filter\VideoCameraReportFilter;
use App\Models\ApiV1\VideoCamera;

class ReportController extends Controller
{
    public function index(VideoCameraReportFilter $filter, ExportReportInterface $exportReport = null)
    {
        $videoCamera = VideoCamera::reportFilter($filter)->get();

        if ($exportReport) {
            return (new ExportReport($exportReport, $videoCamera))->generateDocument();
        }

        return 1;
    }
}
