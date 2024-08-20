<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class WeatherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'day' => ['required', 'date_format:Y-m-d'],
            'city' => ['nullable', 'string'],
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     * @throws ApiException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ApiException($validator->errors()->first(), '102');
    }
}
