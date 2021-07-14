<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomAgentRequest extends FormRequest
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
            'rut'             => 'required|max:25',
            'name'            => 'required|max:100',
            'contact_person'  => 'nullable|max:100',
            'rate'            => 'nullable|numeric|gt:0|between:0,999999999999',
            'bank'            => 'nullable|max:100',
            'account_number'  => 'nullable|max:100',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'contact_person' => 'Persona de contacto',
            'rate'           => 'Tarifa Base',
            'bank'           => 'Banco para depósitos',
            'account_number' => 'Número de cuenta corriente',
        ];
    }
}
