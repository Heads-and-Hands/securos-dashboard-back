<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\VideoCameras\{VideoCamerasCollection, VideoCamerasShortCollection};
use App\Models\ApiV1\{Filter\VideoCameraFilter, Filter\VideoCameraShortFilter, VideoCamera};

class VideoCameraController extends Controller
{
    public function index(VideoCameraFilter $filter): VideoCamerasCollection
    {
        $videoCameras = VideoCamera::filter($filter)->offsetPaginate();

        return new VideoCamerasCollection($videoCameras);
    }

    public function camerasShort(VideoCameraShortFilter $filter)
    {
        $videoCameras = VideoCamera::query()
            ->select('id', 'name')
            ->shortFilter($filter)->offsetPaginate();

        return new VideoCamerasShortCollection($videoCameras);
    }
}
