<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Securos\SecurosCameraPassport;
use App\Http\{Controllers\Controller,
    Requests\ApiV1\VideoCamera\VideoCameraPassportRequest,
    Resources\ApiV1\Passports\PassportsResource,
    Resources\ApiV1\VideoCameras\VideoCameraResource};
use App\Models\ApiV1\VideoCamera;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoCameraPassportController extends Controller
{
    public function store(VideoCameraPassportRequest $request)
    {
        $videoCamera = VideoCamera::findOrFail($request->id);

        // Раскомментировать:

        /*
        $response = SecurosCameraPassport::createCameraPassport($request->all());
        if (isset($response->status) && $response->status > 300) {
            return response()->json(['message' => 'Securos API Response: ' . $response->message], $response->status);
        }
        else {
            self::loadPassportParamsFromSecurosApi($passport);
            return new VideoCameraResource($passport);
        }*/

        // Удалить до конца метода:

//        $response = SecurosCameraPassport::createCameraPassport($request->all());
//
//        if (isset($response->status) && $response->status > 300) {
//            return response()->json(['message' => $response->message], $response->status);
//        }

        $videoCamera->update([
            'passport' => $request->stream
        ]);

        return new VideoCameraResource($videoCamera);
    }

    public function show(VideoCamera $passport): PassportsResource
    {
        if (!is_null($passport->passport)) {
            self::loadPassportParamsFromSecurosApi($passport);
        }

        return new PassportsResource($passport);
    }

    public function update(VideoCameraPassportRequest $request, VideoCamera $passport)
    {
        $response = SecurosCameraPassport::updateCameraPassport($passport->id, $request->stream);
        if (isset($response->status) && $response->status > 300) {
            return response()->json(['message' => 'Securos API Response: ' . $response->message], $response->status);
        }
        else {
            self::loadPassportParamsFromSecurosApi($passport);
            return new VideoCameraResource($passport);
        }
    }

    public function destroy(VideoCamera $passport)
    {
//        $response = SecurosCameraPassport::deleteCameraPassport($passport->id);
//
//        if (isset($response->status) && $response->status > 300) {
//            return response()->json(['message' => $response->message], $response->status);
//        }

        $passport->update([
            'passport' => null
        ]);

        return new VideoCameraResource($passport);
    }

    private static function loadPassportParamsFromSecurosApi(VideoCamera $passport) {
        $data = SecurosCameraPassport::getCameraPassport($passport->passport);
        if (isset($data->stream)) {
            $passport->width =  $data->stream->width;
            $passport->height = $data->stream->height;
            $passport->kbps = $data->stream->kbps;
            $passport->fps = $data->stream->fps;
        }
    }
}
