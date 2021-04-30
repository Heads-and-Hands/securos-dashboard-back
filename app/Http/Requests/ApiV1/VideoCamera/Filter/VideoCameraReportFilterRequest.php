<?php
declare(strict_types=1);

namespace App\Http\Requests\ApiV1\VideoCamera\Filter;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class VideoCameraReportFilterRequest extends FormRequest
{
    protected const DATE_FORMAT = "Ymd\THis";

    public function rules(): array
    {
        $validateIdList =
            function ($attribute, $value, $fail) {
                $ids = explode(',', $value);
                foreach ($ids as $id) {
                    Validator::make(['id' => $id], [
                        'id' => ['required', 'integer', 'min:1']
                    ])->validate();
                }
            };

        $validateDateRange = function ($attribute, $value, $fail) {
            $dates = explode('-', $value);
            if (count($dates) !== 2) {
                $fail("Incorrect date range format!");
            }
            foreach ($dates as $date) {
                if (!Carbon::canBeCreatedFromFormat($date, self::DATE_FORMAT)) {
                    $fail("Incorrect date value format!");
                }
            }
            $delta = Carbon::parse($dates[1])->getTimestamp() - Carbon::parse($dates[0])->getTimestamp();
            if ($delta <= 0) {
                $fail("Incorrect period format!");
            }
        };

        $rules = [
            'ids' => ['string', $validateIdList],
            'noIds' => ['string', $validateIdList],
            'rangeOfDate' => ['required', 'string', $validateDateRange],
            'timezoneOffset' => ['required', 'integer', 'min:-1410',  'max:1410']
        ];

        if ($this->request->has('ids')) {
            $rules['noIds'] = 'prohibited';
        }

        return $rules;
    }
}
