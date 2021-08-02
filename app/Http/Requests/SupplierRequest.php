<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name'             => 'required|max:100',
            'isin'             => 'required|max:15', 
            'iban'             => 'required|max:50', 
            'phone'            => 'required|max:50', 
            'email'            => 'required|email', 
            'bank'             => 'required|max:15',    
            'place'            => 'array',
            'place.*'          => 'required|string',
            'origin_address'   => 'array',
            'origin_address.*' => 'nullable|max:255',
        ];
        
        return $rules;
    }

    public function attributes()
    {
        return [
            'name'        => 'Nombre Proveedor',
            'phone'      => 'Telefono',
            'bank'       => 'Banco',
            'origin_address'   => 'dirección de origen'
        ];
    }
}
