<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationServiceRequest extends FormRequest
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
            'service_id'  => 'required|exists:services,id',
            'amount'      => 'required|numeric',
            'amount2'     => 'required|numeric',
            'currency_id' => 'required|exists:currencies,id',
            'currency2_id' => 'required|exists:currencies,id',
            
        ];

        return $rules;
    }
}
