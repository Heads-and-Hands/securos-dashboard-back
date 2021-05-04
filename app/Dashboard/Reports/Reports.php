<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;

use App\Dashboard\Reports\Report\HourCountReport;
use App\Dashboard\Reports\Report\ModeTimeReport;
use App\Dashboard\Reports\Report\NotWorkingCameraCountReport;

class Reports
{
    private static HourCountReport $hourCountReport;
    private static NotWorkingCameraCountReport $notWorkingCameraCountReport;
    private static ModeTimeReport $modeTimeReport;

    private static function initReports(ReportParams $params)
    {
        self::$hourCountReport = new HourCountReport($params);
        self::$notWorkingCameraCountReport = new NotWorkingCameraCountReport($params);
        self::$modeTimeReport = new ModeTimeReport($params);
    }

    public static function makeReports(ReportParams $params) : array
    {
        self::initReports($params);
        self::$modeTimeReport->readData();
        return [
            'hourCount' => self::$hourCountReport->getResult(),
            'notWorkingCameraCountReport' => self::$notWorkingCameraCountReport->getResult(),
            'problemTimeReport' => self::$modeTimeReport->getResult(ModeTimeReport::REPORT_TYPE_PROBLEM_TIME),
            'availableTimeReport' => self::$modeTimeReport->getResult(ModeTimeReport::REPORT_TYPE_AVAILABLE_TIME),
            'availablePercentReport' => self::$modeTimeReport->getResult(ModeTimeReport::REPORT_TYPE_AVAILABLE_PERCENT),
        ];
    }
}
