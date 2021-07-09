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
            'description'              => 'nullable|max:250',
            'estimated_date'           => 'nullable|date',
            'fee1'                     => 'nullable|numeric',
            'fee1_date'                => 'nullable|date',
            'fee2'                     => 'nullable|numeric',
            'fee2_date'                => 'nullable|date',
            'fee3'                     => 'nullable|numeric',
            'condition'                => 'required|exists:application_cond_sales,name',
            'amount'                   => 'required|numeric|gt:0|between:1,999999999999',
            'services'                 => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'services.required'         => 'Debe seleccionar al menos 1 servicios',
            'currency_id.required'      => 'El campo Moneda es obligatorio.',
        ];
    }

    public function attributes()
    {
        return [
            'supplier_id' => 'Proveedor',
            'amount'      => 'Monto Total de Operacion',
            'condition'   => 'Condicion de Venta del Proveedor'
        ];
    }
}
