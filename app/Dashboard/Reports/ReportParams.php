<?php
declare(strict_types=1);

namespace App\Dashboard\Reports;


use App\Models\Common\VideoCamera;
use Illuminate\Database\Eloquent\Collection;

class ReportParams
{
    public Collection $videoCameras;
    public $workingVideoCameraIds = [];
    public \DateTimeInterface $startDateTime;
    public \DateTimeInterface $endDateTime;
    // Сдвиг временной зоны пользователя относительно UTC+0 в минутах
    public int $dateTimeOffset;

    public function __construct(
        Collection $videoCameras,
        \DateTimeInterface $startDateTime,
        \DateTimeInterface $endDateTime,
        int $dateTimeOffset)
    {
        $this->videoCameras = $videoCameras;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->dateTimeOffset = $dateTimeOffset;

        foreach ($videoCameras as $videoCamera) {
            if (($videoCamera->status != VideoCamera::$statuses[VideoCamera::NOT_IN_OPERATION])
                && ($videoCamera->status != VideoCamera::$statuses[VideoCamera::UNKNOWN]))
            {
                $this->workingVideoCameraIds []= $videoCamera->id;
            }
        }
    }

}
