<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'supplier_id'              => 'nullable|exists:suppliers,id',
            'currency_id'              => 'required|exists:currencies,id',
            'description'              => 'required|max:250',
            'estimated_date'           => 'required|date',
            'fee1'                     => 'required|numeric',
            'fee1_date'                => 'required|date',
            'fee2'                     => 'required|numeric',
            'fee2_date'                => 'required|date',
            'fee3'                     => 'nullable|numeric',
            'fee3_date'                => 'nullable|date',
            'amount'                   => 'required|numeric',
        ];

        return $rules;
    }
}
