<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class TransportRequest extends FormRequest
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
            'application_id'             => 'required|exists:applications,id',
            'address_destination'        => 'required',
            'address_origin'             => 'required',
            'description'                => 'nullable|max:250',
            'estimated_date'             => 'required|date',
            'dataLoad'                   => 'required|array',
            "dataLoad.*.length"          => 'sometimes|required',
            "dataLoad.*.width"           => 'sometimes|required',
            "dataLoad.*.height"          => 'sometimes|required',
            "dataLoad.*.weight"          => 'required|numeric',
            "dataLoad.*.type_load"       => 'sometimes|required',
            "dataLoad.*.type_container"  => 'sometimes|required',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'application_id'             => 'Nro. Solicitud',
            'address_destination'        => 'Origen',
            'address_origin'             => 'Destino',
            'estimated_date'             => 'Fecha estimada',
            'dataLoad'                   => 'Datos de carga',
            'dataLoad.*.length'          => 'Largo',
            'dataLoad.*.width'           => 'Archo',
            "dataLoad.*.height"          => "Altura",
            "dataLoad.*.weight"          => 'Peso',
            "dataLoad.*.type_load"       => 'Tipo de carga',
            "dataLoad.*.type_container"  => 'Container',
        ];
    }
}
