<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
        $id = is_null($this->currency) ? 0 : $this->currency;
        
        $rules = [
            'code'               => 'required|max:10|unique:currencies,code,' . $id,
            'name'               => 'required|max:50|unique:currencies,name,' . $id,
            'symbol'             => 'required|max:5',
        ];

        return $rules;
    }
}
