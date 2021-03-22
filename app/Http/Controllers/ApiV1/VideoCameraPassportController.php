<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Securos\SecurosCameraPassport;
use App\Http\{Controllers\Controller,
    Requests\ApiV1\VideoCamera\VideoCameraPassportRequest,
    Resources\ApiV1\Passports\PassportsResource,
    Resources\ApiV1\VideoCameras\VideoCameraResource};
use App\Models\ApiV1\VideoCamera;

class VideoCameraPassportController extends Controller
{
    public function store(VideoCameraPassportRequest $request)
    {
        $videoCamera = VideoCamera::findOrFail($request->id);

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
        return new PassportsResource($passport);
    }

    public function update(VideoCameraPassportRequest $request, VideoCamera $passport): VideoCameraResource
    {
        #TODO здесь должен быть запрос по их апи
        $passport->update([
             'passport' => $request->stream
        ]);

        return new VideoCameraResource($passport);
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
}
