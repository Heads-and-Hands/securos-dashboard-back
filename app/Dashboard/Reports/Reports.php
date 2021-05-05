<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;

use App\Dashboard\Reports\Custom\AvailableTimeReport;
use App\Dashboard\Reports\Custom\AvailableTimeReportPercent;
use App\Dashboard\Reports\Custom\ProblemTimeReport;
use App\Dashboard\Reports\Custom\TotalTimeReport;
use App\Dashboard\Reports\Custom\NotWorkingCameraCountReport;
use App\Dashboard\Reports\Readers\ModeTimeReader;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Reports
{
    private static TotalTimeReport $hourCountReport;
    private static NotWorkingCameraCountReport $notWorkingCameraCountReport;
    private static ProblemTimeReport $problemTimeReport;
    private static AvailableTimeReport $availableTimeReport;
    private static AvailableTimeReportPercent $availableTimeReportPercent;

    private static function initReports(ReportParams $params)
    {
        self::$hourCountReport = new TotalTimeReport($params);
        self::$notWorkingCameraCountReport = new NotWorkingCameraCountReport($params);
        self::$problemTimeReport = new ProblemTimeReport($params);
        self::$availableTimeReport = new AvailableTimeReport($params);
        self::$availableTimeReportPercent= new AvailableTimeReportPercent($params);
    }

    public static function makeReports(ReportParams $params) : array
    {
        self::initReports($params);

        $modeTimeReader = new ModeTimeReader();
        try {
            $modeTimeReader->readData($params);
        }
        catch (HttpException $e) {
            throw $e;
        }

        return [
            'totalTime' => self::$hourCountReport->getResult(),
            'notWorkingCameraCount' => self::$notWorkingCameraCountReport->getResult(),
            'problemTime' => self::$problemTimeReport->getResult($modeTimeReader->getResult()),
            'availableTime' => self::$availableTimeReport->getResult($modeTimeReader->getResult()),
            'availableTimePercent' => self::$availableTimeReportPercent->getResult($modeTimeReader->getResult())
        ];
    }
}
