<?php
declare(strict_types=1);

namespace App\Http\Requests\ApiV1;

use App\Models\ApiV1\VideoCamera;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoCameraFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rangeOfIpCameras' => ['string'],
            'statusCameras' => [
                function ($attribute, $value, $fail) {
                    $statuses = explode(',', $value);
                    foreach ($statuses as $status) {
                        if (!in_array($status, VideoCamera::$statuses, true)) {
                            $fail("$status invalid value!");
                        }
                    }
                }
            ],
            'statusExploitation' => [
                function ($attribute, $value, $fail) {
                    $statuses = explode(',', $value);
                    foreach ($statuses as $status) {
                        if (!in_array($status, VideoCamera::$statusesExploitation, true)) {
                            $fail("$status invalid value!");
                        }
                    }
                }
            ],
            'nameSort' => [Rule::in(VideoCamera::$sort)],
            'statusCamerasSort' => [Rule::in(VideoCamera::$sort)],
            'statusExploitationSort' => [Rule::in(VideoCamera::$sort)],
            'ipCamerasSort' => [Rule::in(VideoCamera::$sort)],
            'ipServerSort' => [Rule::in(VideoCamera::$sort)],
            'q' => ['string'],
        ];
    }
}
