<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Securos\SecurosCameraPassport;
use App\Securos\SecurosCameraPhoto;
use App\Securos\SecurosCameras;
use Carbon\Carbon;
use App\Http\{Controllers\Controller,
    Requests\ApiV1\VideoCamera\VideoCameraPassportRequest,
    Resources\ApiV1\Passports\PassportsResource,
    Resources\ApiV1\VideoCameras\VideoCameraResource};
use App\Models\ApiV1\VideoCamera;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoCameraPassportController extends Controller
{
    public function store(VideoCameraPassportRequest $request, VideoCamera $camera)
    {
        $response = SecurosCameraPassport::createCameraPassport($camera->id, $request->stream);
        if (isset($response->status) && $response->status > 300) {
            return response()->json(['message' => $response->message], $response->status);
        }
        if (isset($response->update_time, $response->approved, $response->passport)) {
            $camera->update_time = SecurosCameras::formatDateTime($response->update_time);
            $camera->approved = $response->approved;
            $camera->passport = $response->passport;
            $camera->status_exploitation = SecurosCameras::getStatusExploitation($camera);
            $camera->save();
        }
        self::loadPassportParamsFromSecurosApi($camera);
        return new VideoCameraResource($camera);
    }

    public function show(VideoCamera $camera): PassportsResource
    {
        if (!is_null($camera->passport)) {
            self::loadPassportParamsFromSecurosApi($camera);
        }
        $camera->image = SecurosCameraPhoto::getPhoto($camera->id);
        return new PassportsResource($camera);
    }

    public function update(VideoCameraPassportRequest $request, VideoCamera $camera)
    {
        $response = SecurosCameraPassport::updateCameraPassport($camera->id, $request->stream);
        if (isset($response->status) && $response->status > 300) {
            return response()->json(['message' => $response->message], $response->status);
        }
        if (isset($response->update_time)) {
            $camera->update_time = SecurosCameras::formatDateTime($response->update_time);
            $camera->save();
        }
        self::loadPassportParamsFromSecurosApi($camera);
        return new VideoCameraResource($camera);
    }

    public function approve(VideoCamera $camera)
    {
        $response = SecurosCameraPassport::approveCameraPassport($camera->id);
        if (isset($response->status) && $response->status > 300) {
            return response()->json(['message' => $response->message], $response->status);
        }
        if (isset($response->update_time, $response->approved)) {
            $camera->update_time = SecurosCameras::formatDateTime($response->update_time);
            $camera->approved = $response->approved;
            $camera->status_exploitation = SecurosCameras::getStatusExploitation($camera);
            $camera->save();
        }
        self::loadPassportParamsFromSecurosApi($camera);
        return new VideoCameraResource($camera);
    }

    public function destroy(VideoCamera $camera)
    {
        $response = SecurosCameraPassport::deleteCameraPassport($camera->id);
        if (isset($response->status) && $response->status > 300) {
            return response()->json(['message' => $response->message], $response->status);
        }
        $camera->approved = false;
        $camera->passport = null;
        $camera->update_time = null;
        $camera->status_exploitation = VideoCamera::NOT_FILLED;
        $camera->save();
        return new VideoCameraResource($camera);
    }

    private static function loadPassportParamsFromSecurosApi(VideoCamera $camera)
    {
        $data = SecurosCameraPassport::getCameraPassport($camera->passport);
        if (isset($data->stream)) {
            $camera->width =  $data->stream->width;
            $camera->height = $data->stream->height;
            $camera->kbps = $data->stream->kbps;
            $camera->fps = $data->stream->fps;
        }
    }
}
