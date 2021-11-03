<?php

namespace App\Http\Requests\Admin\Factoring;

use Illuminate\Foundation\Http\FormRequest;

class FeesHistoryRequest extends FormRequest
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
            'payer_id'      => 'nullable|exists:payers,id',
            'rate'          => 'required|numeric',
            'mora_rate'     => 'required|numeric',
            'discount'      => 'required|numeric',
            'commission'    => 'required|numeric', 
        ];

        return $rules;
    }
}
