<?php

namespace App\Http\Requests\Admin\Rates;

use Illuminate\Foundation\Http\FormRequest;

class LocalTransportRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            "from"          => "required",
            "to"            => "required",
            "weight"        => 'required|numeric',
            "weight_limit"  => 'required|numeric',
            "amount"        => 'required|numeric',
        ];

        return $rules;
    }
}
