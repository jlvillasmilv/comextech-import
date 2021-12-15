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
            'dest_address'               => 'required_if:mode_selected,==,COURIER',
            'origin_address'             => 'required_if:mode_selected,==,COURIER',
            'description'                => 'nullable|max:250',
            'estimated_date'             => 'required|date',
            'mode_selected'              => 'required|string|max:15',
            'dataLoad'                   => 'required|array',
            "dataLoad.*.weight"          => 'required|numeric|gt:0|between:0,99999',
            "dataLoad.*.type_load"       => 'required_if:mode_selected,in:COURIER, TERRESTRE, AEREO, CONSOLIDADO',
            "dataLoad.*.type_container"  => 'required_if:mode_selected,==,CONTAINER',
        ];

        
        if($this->get('mode_selected') == 'COURIER' || $this->get('mode_selected') == 'TERRESTRE' || $this->get('mode_selected') == 'AEREO'  || $this->get('mode_selected') == 'CONSOLIDADO' )        
            $rules = array_merge($rules, [
                'dataLoad.*.length'  => 'required|numeric',
                'dataLoad.*.width'   => 'required|numeric',
                'dataLoad.*.height'  => 'required|numeric',
                'dataLoad.*.cbm'     => 'required|numeric|gt:0|between:0,99999',
        ]);

        if($this->get('mode_selected') == 'CONTAINER' || $this->get('mode_selected') == 'AEREO' || $this->get('mode_selected') == 'CONSOLIDADO')        
            $rules = array_merge($rules, [
                'origin_port_id'  => 'required|numeric',
                'dest_port_id'    => 'required|numeric',
        ]);

        return $rules;
    }

    public function attributes()
    {
        return [
            'mode_selected'              => 'Tipo de Transporte',
            'application_id'             => 'Nro. Solicitud',
            'dest_address'               => 'Origen',
            'origin_port_id'             => 'Puerto Origen',
            'origin_address'             => 'Destino',
            'dest_port_id'               => 'Puerto Destino',
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
