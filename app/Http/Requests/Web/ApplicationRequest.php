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
            'currency_id'              => 'nullable|exists:currencies,id',
            'description'              => 'nullable|max:250',
            'estimated_date'           => 'nullable|date',
            'fee1'                     => 'nullable|numeric',
            'fee1_date'                => 'nullable|date',
            'fee2'                     => 'nullable|numeric',
            'fee2_date'                => 'nullable|date',
            'fee3'                     => 'nullable|numeric',
            'fee3_date'                => 'nullable|date',
            'amount'                   => 'nullable|numeric',
            'services'                 => 'nullable',
        ];

        return $rules;
    }
}
