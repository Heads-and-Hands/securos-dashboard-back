<?php


namespace App\Http\Requests\ApiV1;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['string'],
            'key' => ['string'],
        ];
    }
}
