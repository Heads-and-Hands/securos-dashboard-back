<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Dashboard\Cameras\Cameras;
use App\Securos\SecurosCameraPassport;
use App\Securos\SecurosCameraPhoto;
use App\Securos\SecurosCameras;
use Carbon\Carbon;
use App\Http\{Controllers\Controller,
    Requests\ApiV1\VideoCamera\VideoCameraPassportRequest,
    Resources\ApiV1\VideoCameras\VideoCameraWithImageResource,
    Resources\ApiV1\VideoCameras\VideoCameraResource};
use App\Models\ApiV1\VideoCamera;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoCameraPassportController extends Controller
{
    public function store(VideoCameraPassportRequest $request, VideoCamera $camera)
    {
        $response = SecurosCameraPassport::createCameraPassport($camera->id, $request->stream);
        $camera = self::reloadCameraParams($camera->id);
        return new VideoCameraResource($camera);
    }

    public function show(VideoCamera $camera): VideoCameraWithImageResource
    {
        if (!is_null($camera->passport)) {
            $camera = self::reloadCameraParams($camera->id);
        }
        $camera->image = SecurosCameraPhoto::getPhoto($camera->id);
        return new VideoCameraWithImageResource($camera);
    }

    public function update(VideoCameraPassportRequest $request, VideoCamera $camera)
    {
        $response = SecurosCameraPassport::updateCameraPassport($camera->id, $request->stream);
        $camera = self::reloadCameraParams($camera->id);
        return new VideoCameraResource($camera);
    }

    public function approve(VideoCamera $camera)
    {
        $response = SecurosCameraPassport::approveCameraPassport($camera->id);
        $camera = self::reloadCameraParams($camera->id);
        return new VideoCameraResource($camera);
    }

    public function destroy(VideoCamera $camera)
    {
        $response = SecurosCameraPassport::deleteCameraPassport($camera->id);
        $camera = self::reloadCameraParams($camera->id);
        return new VideoCameraResource($camera);
    }

    /*
     *  Обновляет данные о состоянии камеры из API Securos
     *  Возвращает объект камеры с заполненными данными паспорта
     */
    private static function reloadCameraParams(int $cameraId) : VideoCamera
    {
        Cameras::updateCamera($cameraId);
        $camera = VideoCamera::findOrFail($cameraId);
        if (!is_null($camera->passport)) {
            $passportParams = SecurosCameraPassport::getCameraPassport($camera->passport);
            if (isset($passportParams->stream)) {
                $camera->width = $passportParams->stream->width;
                $camera->height = $passportParams->stream->height;
                $camera->kbps = $passportParams->stream->kbps;
                $camera->fps = $passportParams->stream->fps;
            }
        }
        return $camera;
    }
}
