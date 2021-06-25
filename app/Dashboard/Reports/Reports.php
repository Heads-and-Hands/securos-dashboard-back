<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;

use App\Dashboard\Reports\Custom\WorkingTimeReport;
use App\Dashboard\Reports\Custom\WorkingTimeReportPercent;
use App\Dashboard\Reports\Custom\SimpleTimeReport;
use App\Dashboard\Reports\Custom\TotalTimeReport;
use App\Dashboard\Reports\Custom\NotWorkingCameraCountReport;
use App\Dashboard\Reports\Readers\MetricTimeReader;
use App\Securos\SecurosMetrics;

class Reports
{
    public const REPORT_TOTAL_TIME = 'totalTime';
    public const REPORT_NOT_WORKING_CAMERA_COUNT = 'notWorkingCameraCount';
    public const REPORT_PROBLEM_TIME = 'problemTime';
    public const REPORT_WORKING_TIME = 'workingTime';
    public const REPORT_WORKING_TIME_PERCENT = 'workingTimePercent';
    public const REPORT_ARCHIVE_TIME = 'archiveTime';

    public const KEY_INTERVALS = 'intervals';
    public const KEY_START = 'start';
    public const KEY_END = 'end';
    public const KEY_VALUE = 'value';
    public const KEY_TOTAL_VALUE = 'totalValue';
    public const KEY_TIME_UNIT = 'timeUnit';

    private static TotalTimeReport $hourCountReport;
    private static NotWorkingCameraCountReport $notWorkingCameraCountReport;
    private static SimpleTimeReport $problemTimeReport;
    private static SimpleTimeReport $archiveTimeReport;
    private static WorkingTimeReport $workingTimeReport;
    private static WorkingTimeReportPercent $workingTimeReportPercent;

    private static function initReports(ReportParams $params)
    {
        self::$hourCountReport = new TotalTimeReport($params);
        self::$notWorkingCameraCountReport = new NotWorkingCameraCountReport($params);
        self::$problemTimeReport = new SimpleTimeReport($params);
        self::$archiveTimeReport = new SimpleTimeReport($params);
        self::$workingTimeReport = new WorkingTimeReport($params);
        self::$workingTimeReportPercent= new WorkingTimeReportPercent($params);
    }

    /**
     * @throws \Exception
     */
    public static function makeReports(ReportParams $params) : array
    {
        self::initReports($params);

        // Данные считываются один раз из API клиента и затем используются в трёх различных отчетах
        $availableTimeReader = new MetricTimeReader(SecurosMetrics::TAG_AVAILABLE);
        $availableTimeReader->readData($params);

        $result = [
            self::REPORT_TOTAL_TIME =>
                self::$hourCountReport->getResult($availableTimeReader->getResult()),
            self::REPORT_NOT_WORKING_CAMERA_COUNT =>
                self::$notWorkingCameraCountReport->getResult(),
        ];

        // Если нет работающих камер, формировать остальные отчеты не имеет смысла
        if (count($params->workingVideoCameraIds) == 0) {
            return $result;
        }

        // Данные считываются один раз из API клиента и затем используются в трёх различных отчетах
        $problemStreamTimeReader = new MetricTimeReader(SecurosMetrics::TAG_PROBLEM_STREAM);
        $problemStreamTimeReader->readData($params);

        $result[self::REPORT_PROBLEM_TIME] =
            self::$problemTimeReport->getResult($problemStreamTimeReader->getResult());
        $result[self::REPORT_WORKING_TIME] =
            self::$workingTimeReport->getResult(
                $availableTimeReader->getResult(), $problemStreamTimeReader->getResult());
        $result[self::REPORT_WORKING_TIME_PERCENT] =
            self::$workingTimeReportPercent->getResult(
                $availableTimeReader->getResult(), $problemStreamTimeReader->getResult());

        $archiveTimeReader = new MetricTimeReader(SecurosMetrics::TAG_ARCHIVE);
        $archiveTimeReader->readData($params);

        $result[self::REPORT_ARCHIVE_TIME] =
            self::$archiveTimeReport->getResult($archiveTimeReader->getResult());

        return $result;
    }
}
