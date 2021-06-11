<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $id = is_null($this->company) ? 0 : $this->company;
        
        $rules = [
            'country_id'         => 'required|exists:countries,id',
            'tax_id'             => 'required|max:100|unique:currencies,code,' . $id,
            'name'               => 'required|max:100',
            'address'            => 'required|max:250',
            'email'              => 'required|max:250|email',
            'phone'              => 'required|max:250',
            'contact_name'       => 'nullable|max:250',
            'contact_telf'       => 'nullable|max:250',

        ];

        return $rules;
    }
}
