<?php
declare(strict_types=1);

namespace App\Http\Requests\ApiV1\VideoCamera;

use Illuminate\Foundation\Http\FormRequest;

class VideoCameraPassportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['integer',],
            'stream' => ['array'],
            'stream.fps' => ['integer', 'required'],
            'stream.kbps' => ['integer', 'required'],
            'stream.width' => ['integer', 'required'],
            'stream.height' => ['integer', 'required'],
        ];
    }
}
