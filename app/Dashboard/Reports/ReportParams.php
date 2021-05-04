<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;


use App\Models\Common\VideoCamera;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ReportParams
{
    public Collection $videoCameras;
    // Идентификаторы работающих видеокамер для построения отчета
    public array $workingVideoCameraIds = [];
    public ReportPeriod $period;

    public function __construct(
        Collection $videoCameras,
        Carbon $startDateTime,
        Carbon $endDateTime,
        int $dateTimeOffset)
    {
        $this->videoCameras = $videoCameras;

        foreach ($videoCameras as $videoCamera) {
            if (($videoCamera->status != VideoCamera::$statuses[VideoCamera::NOT_IN_OPERATION])
                && ($videoCamera->status != VideoCamera::$statuses[VideoCamera::UNKNOWN]))
            {
                $this->workingVideoCameraIds []= $videoCamera->id;
            }
        }

        $this->period = new ReportPeriod($startDateTime, $endDateTime, $dateTimeOffset);
    }

}
