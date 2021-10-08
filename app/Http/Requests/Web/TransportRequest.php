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
            'address_destination'        => 'required',
            'address_origin'             => 'required',
            'description'                => 'nullable|max:250',
            'destinacion'                => 'nullable|max:250',
            'estimated_date'             => 'nullable|date',
            'dataLoad'                   => 'required|array',
            'dataLoad.*.mode_selected'   => 'required|string',
            "dataLoad.*.length"          => "required_if:dataLoad.*.mode_selected,in:COURIER,CARGA AEREA,CONSOLIDADO",
            "dataLoad.*.width"           => "required_if:dataLoad.*.mode_selected,in:COURIER,CARGA AEREA,CONSOLIDADO",
            "dataLoad.*.height"          => "required_if:dataLoad.*.mode_selected,in:COURIER,CARGA AEREA,CONSOLIDADO",
            "dataLoad.*.weight"          => "required|numeric",
            "dataLoad.*.type_load"       => 'required_if:dataLoad.*.mode_selected,in:COURIER,CARGA AEREA,CONSOLIDADO',
            "dataLoad.*.type_container"  => 'required_if:dataLoad.*.mode_selected,in:CONTAINER',
        ];

        return $rules;
    }
}
