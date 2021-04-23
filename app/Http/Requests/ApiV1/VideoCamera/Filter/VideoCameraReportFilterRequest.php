<?php
declare(strict_types=1);

namespace App\Http\Requests\ApiV1\VideoCamera\Filter;

use Illuminate\Foundation\Http\FormRequest;

class VideoCameraReportFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ids' => ['string'],
            'rangeOfDate' => ['string'],
            'timezoneOffset' => ['integer']
        ];
    }
}
