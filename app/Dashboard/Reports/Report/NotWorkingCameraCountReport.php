<?php
declare(strict_types=1);


namespace App\Dashboard\Reports\Report;


use App\Models\Common\VideoCamera;

class NotWorkingCameraCountReport extends \App\Dashboard\Reports\BaseReport
{
    public function getResult()
    {
        $count = 0;
        foreach ($this->params->videoCameras as $videoCamera) {
            if ($videoCamera->status == VideoCamera::$statuses[VideoCamera::NOT_IN_OPERATION]) {
                $count++;
            }
        }
        return $count;
    }
}
