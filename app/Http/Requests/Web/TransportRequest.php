<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'origin_port_id'             => 'required_if:mode_selected,in:CONTAINER, AEREO, CONSOLIDADO',
            'dest_port_id'               => 'required_if:mode_selected,in:CONTAINER, AEREO, CONSOLIDADO',
            'dest_address'               => 'required_if:mode_selected,in:COURIER',
            'origin_address'             => 'required_if:mode_selected,in:COURIER',
            'description'                => 'nullable|max:250',
            'estimated_date'             => 'required|date',
            'dataLoad'                   => 'required|array',
            'mode_selected'              => 'required|string|max:15',
            "dataLoad.*.length"          => "required_if:mode_selected,in:COURIER, TERRESTRE, AEREO, CONSOLIDADO",
            "dataLoad.*.width"           => "required_if:mode_selected,in:COURIER, TERRESTRE, AEREO, CONSOLIDADO",
            "dataLoad.*.high"            => "required_if:mode_selected,in:COURIER, TERRESTRE, AEREO, CONSOLIDADO",
            "dataLoad.*.weight"          => "required|numeric",
            "dataLoad.*.type_load"       => 'required_if:mode_selected,in:COURIER, TERRESTRE, AEREO, CONSOLIDADO',
            "dataLoad.*.type_container"  => 'required_if:mode_selected,in:CONTAINER',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'application_id'             => 'Nro. Solicitud',
            'dest_address'               => 'Origen',
            'origin_address'             => 'Destino',
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
