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
            'destinacion'                => 'nullable|max:250',
            'estimated_date'             => 'required|date',
            'dataLoad'                   => 'required|array',
            'dataLoad.*.type_transport'  => 'required|string',
            "dataLoad.*.length"          => "required_if:dataLoad.*.type_transport,in:COURIER,CARGA AEREA,CONSOLIDADO",
            "dataLoad.*.width"           => "required_if:dataLoad.*.type_transport,in:COURIER,CARGA AEREA,CONSOLIDADO",
            "dataLoad.*.height"          => "required_if:dataLoad.*.type_transport,in:COURIER,CARGA AEREA,CONSOLIDADO",
            "dataLoad.*.weight"          => "required|numeric",
            "dataLoad.*.type_load"       => 'required_if:dataLoad.*.type_transport,in:COURIER,CARGA AEREA,CONSOLIDADO',
            "dataLoad.*.type_container"  => 'required_if:dataLoad.*.type_transport,in:CONTAINER',
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
            'dataLoad.*.type_transport'  => 'Tipo de transporte',
            'dataLoad.*.length'          => 'Largo',
            'dataLoad.*.width'           => 'Archo',
            "dataLoad.*.height"          => "Altura",
            "dataLoad.*.weight"          => 'Peso',
            "dataLoad.*.type_load"       => 'Tipo de carga',
            "dataLoad.*.type_container"  => 'Container',
        ];
    }
}
