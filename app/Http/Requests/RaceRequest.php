<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            "start_date" => 'required|string|max:255|min:3',
            "end_date" => 'required|string|max:255|min:3',
            "prize_value" => "required|decimal:0,2|min:1|max:9999999999.99",
            "is_canceled" => "required|boolean",
            "maximum_number_of_drivers" => "required|numeric",
            "speedway_id" => "required|exists:speedways,id",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
