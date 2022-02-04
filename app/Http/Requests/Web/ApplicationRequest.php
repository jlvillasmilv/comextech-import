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
            // 'supplier_id'              => 'required_if:statusSuppliers,with',
            'currency_id'              => 'required|exists:currencies,id',
            'type_transport'           => 'required',
            // 'valuePercentage'          => 'required_if:statusSuppliers,with',
            'condition'                => 'required|exists:application_cond_sales,name',
            'amount'                   => 'required|numeric|gt:0|between:1,999999999999',
            'statusSuppliers'          => 'required',
            'ecommerce_url'            => 'required_if:statusSuppliers,E-commerce',
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
            'supplier_id'     => 'Proveedor',
            'amount'          => 'Monto Operación',
            'valuePercentage' => 'Porcentaje de Pago',
            'condition'       => 'Condicion de Venta del Proveedor',
            'type_transport'  => 'Tipo de Transporte'
        ];
    }
}
