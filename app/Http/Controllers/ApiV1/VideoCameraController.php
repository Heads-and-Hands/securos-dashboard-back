<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Jobs\SecurosCamerasJob;
use App\Http\Resources\ApiV1\VideoCameras\{VideoCamerasCollection,
    VideoCamerasIpServerCollection,
    VideoCamerasShortCollection};
use App\Models\ApiV1\{Filter\VideoCameraFilter,
    Filter\VideoCameraIpServerFilter,
    Filter\VideoCameraShortFilter,
    VideoCamera};

class VideoCameraController extends Controller
{
    public function index(VideoCameraFilter $filter)
    {
        if ((bool)request('updateCameras', false)) {
            dispatch(new SecurosCamerasJob());

            return response()->json(['status' => 'success'], 200);
        }
        $videoCameras = VideoCamera::filter($filter)->offsetPaginate();

        return new VideoCamerasCollection($videoCameras);
    }

    public function camerasShort(VideoCameraShortFilter $filter): VideoCamerasShortCollection
    {
        $videoCameras = VideoCamera::getShortCameras($filter);

        return new VideoCamerasShortCollection($videoCameras);
    }

    public function camerasIpServer(VideoCameraIpServerFilter $filter): VideoCamerasIpServerCollection
    {
        $ipServer = VideoCamera::getCamerasIpServer($filter);

        return new VideoCamerasIpServerCollection($ipServer);
    }
}
