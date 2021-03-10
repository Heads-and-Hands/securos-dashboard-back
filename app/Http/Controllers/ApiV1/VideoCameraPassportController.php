<?php
declare(strict_types=1);

namespace App\Http\Controllers\ApiV1;

use App\Http\{Controllers\Controller,
    Requests\ApiV1\VideoCamera\VideoCameraPassportRequest,
    Resources\ApiV1\VideoCameras\VideoCameraResource};
use App\Models\ApiV1\VideoCamera;

class VideoCameraPassportController extends Controller
{
    public function store(VideoCameraPassportRequest $request): VideoCameraResource
    {
        #TODO здесь должен быть запрос по их апи
        $videoCamera = VideoCamera::findOrFail($request->id);
        $videoCamera->update([
            'passport' => $request->stream
        ]);

        return new VideoCameraResource($videoCamera);
    }

    public function show(VideoCamera $passport): VideoCameraResource
    {
        return new VideoCameraResource($passport);
    }

    public function update(VideoCameraPassportRequest $request, VideoCamera $passport): VideoCameraResource
    {
        #TODO здесь должен быть запрос по их апи
        $passport->update([
             'passport' => $request->stream
        ]);

        return new VideoCameraResource($passport);
    }

    public function destroy(VideoCamera $passport): VideoCameraResource
    {
        #TODO здесь должен быть запрос по их апи
        $passport->update([
            'passport' => null
        ]);

        return new VideoCameraResource($passport);
    }
}
