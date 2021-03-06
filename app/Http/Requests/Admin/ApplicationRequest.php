<?php

namespace App\Http\Requests\Admin;

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
            'application_statuses_id'  => 'required|exists:application_statuses,id',
            'amount'                   => 'required|array',
            'amount.*'                 => 'required|numeric',
            'fee_date.*'               => 'required|date',
            'detail_id.*'              => 'required',
            'currency_id.*'            => 'required|exists:currencies,id',
        ];

        return $rules;
    }
}
