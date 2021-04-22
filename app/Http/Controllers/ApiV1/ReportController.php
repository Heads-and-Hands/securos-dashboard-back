<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Custom\Contracts\ExportReportInterface;
use App\Custom\ExportReport\ExportReport;
use App\Http\Controllers\Controller;
use App\Models\ApiV1\Filter\VideoCameraReportFilter;
use App\Models\ApiV1\VideoCamera;
use App\Securos\SecurosMetrics;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(VideoCameraReportFilter $filter, ExportReportInterface $exportReport = null)
    {
        $videoCameras = VideoCamera::reportFilter($filter)->get();

        if ($exportReport) {
            return (new ExportReport($exportReport, $videoCameras))->generateDocument();
        }

        //return $videoCameras;


        // Рабочий пример пробного запроса к API
        /*
        $data = SecurosMetrics::getMetrics(
            'available',
            [1, 100, 101],
            Carbon::parse('20210401T000000'),
            Carbon::parse('20210403T000000'));
        return json_encode($data);
        */

        return 1;
    }
}
