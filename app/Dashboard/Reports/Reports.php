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
    public const REPORT_TOTAL_TIME = 'totalTime';
    public const REPORT_NOT_WORKING_CAMERA_COUNT = 'notWorkingCameraCount';
    public const REPORT_PROBLEM_TIME = 'problemTime';
    public const REPORT_AVAILABLE_TIME = 'availableTime';
    public const REPORT_AVAILABLE_TIME_PERCENT = 'availableTimePercent';

    public const KEY_INTERVALS = 'intervals';
    public const KEY_START = 'start';
    public const KEY_END = 'end';
    public const KEY_VALUE = 'value';
    public const KEY_TOTAL_VALUE = 'totalValue';
    public const KEY_TIME_UNIT = 'timeUnit';

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

        $result = [
            self::REPORT_TOTAL_TIME =>
                self::$hourCountReport->getResult(),
            self::REPORT_NOT_WORKING_CAMERA_COUNT =>
                self::$notWorkingCameraCountReport->getResult(),
        ];

        // Если нет работающих камер, формировать остальные отчеты не имеет смысла
        if (count($params->workingVideoCameraIds) == 0) {
            return $result;
        }

        // Даные считываются один раз из API клиента и затем используются в трёх различных отчетах
        $modeTimeReader = new ModeTimeReader();
        try {
            $modeTimeReader->readData($params);
        }
        catch (HttpException $e) {
            throw $e;
        }

        try {
            $result[self::REPORT_PROBLEM_TIME] =
                self::$problemTimeReport->getResult($modeTimeReader->getResult());
            $result[self::REPORT_AVAILABLE_TIME] =
                self::$availableTimeReport->getResult($modeTimeReader->getResult());
            $result[self::REPORT_AVAILABLE_TIME_PERCENT] =
                self::$availableTimeReportPercent->getResult($modeTimeReader->getResult());
        }
        catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }
}
