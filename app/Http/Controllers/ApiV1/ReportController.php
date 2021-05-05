<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Custom\Contracts\ExportReportInterface;
use App\Custom\ExportReport\ExportReport;
use App\Http\Controllers\Controller;
use App\Models\ApiV1\Filter\VideoCameraReportFilter;
use App\Http\Requests\ApiV1\VideoCamera\Filter\VideoCameraReportFilterRequest;
use App\Models\ApiV1\VideoCamera;
use App\Securos\SecurosMetrics;
use App\Dashboard\Reports\ReportParams;
use App\Dashboard\Reports\Reports;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ReportController extends Controller
{
    public function index(VideoCameraReportFilter $filter, ExportReportInterface $exportReport = null)
    {
        $videoCameras = VideoCamera::reportFilter($filter)->get();
        $dates = explode("-", $filter->getRequest()->get('rangeOfDate'));

        $params = new ReportParams(
            $videoCameras,
            Carbon::parse($dates[0]),
            Carbon::parse($dates[1]),
            intval($filter->getRequest()->get('timezoneOffset'))
        );

        try {
            $reports = Reports::makeReports($params);
        }
        catch (HttpException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        /*
        if ($exportReport) {
            return (new ExportReport($exportReport, $videoCameras))->generateDocument();
        }*/

        return json_encode($reports);

        // Рабочий пример пробного запроса к API
        /*
        $data = SecurosMetrics::getMetrics(
            'available',
            [1, 100, 101],
            Carbon::parse('20210401T000000'),
            Carbon::parse('20210403T000000'));
        return json_encode($data);
        */

        //return 1;
    }

    /*
    public function report(VideoCameraReportFilterRequest $request)
    {
        return 'OK';
    }*/
}

