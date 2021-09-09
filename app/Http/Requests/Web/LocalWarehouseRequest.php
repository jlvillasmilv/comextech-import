<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class LocalWarehouseRequest extends FormRequest
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
            'application_id'        => 'required|exists:applications,id',
            // 'trans_company_id'      => 'required|exists:trans_companies,id',
            'warehouse_id'          => 'required|exists:warehouses,id',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'application_id.required'   => 'Se debe tener una solicitud generada.',
            'warehouse_id.required'     => 'El campo Ubicacion de Bodegaje es obligatorio.',
        ];
    }
}
