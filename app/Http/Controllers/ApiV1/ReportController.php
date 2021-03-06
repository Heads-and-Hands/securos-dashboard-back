<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Dashboard\Export\Contracts\ExportReportInterface;
use App\Dashboard\Export\ExportReport;
use App\Dashboard\Export\ExportReportData;
use App\Dashboard\Auth\DashboardUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\CardResource;
use App\Models\ApiV1\Filter\VideoCameraReportFilter;
use App\Http\Requests\ApiV1\VideoCamera\Filter\VideoCameraReportFilterRequest;
use App\Models\ApiV1\VideoCamera;
use App\Dashboard\Reports\ReportParams;
use App\Dashboard\Reports\Reports;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ReportController extends Controller
{
    public function index(VideoCameraReportFilter $filter, ExportReportInterface $exportReport = null)
    {
        $currentDateTime =  Carbon::now();
        $videoCameras = VideoCamera::reportFilter($filter)->get();
        $dates = explode("-", $filter->getRequest()->get('rangeOfDate'));
        foreach ($dates as $dateIndex => $date) {
            $dates[$dateIndex] = Carbon::parse($date);
        }
        if ($dates[1]->greaterThan($currentDateTime)) {
            $dates[1] = $currentDateTime->copy();
        }

        if ($filter->getRequest()->has('locale')) {
            App::setLocale($filter->getRequest()->get('locale'));
        }

        $params = new ReportParams(
            $videoCameras,
            $dates[0],
            $dates[1],
            intval($filter->getRequest()->get('timezoneOffset'))
        );

        try {
            $reports = Reports::makeReports($params);
        }
        catch (HttpException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        if ($exportReport) {
            $exportReportData = new ExportReportData();
            $exportReportData->reportParams = $params;
            $exportReportData->reports = $reports;
            $exportReportData->userName = DashboardUser::getName();
            return (new ExportReport($exportReport, $exportReportData))->generateDocument();
        }

        return response()->json($reports, 200);
    }

}

