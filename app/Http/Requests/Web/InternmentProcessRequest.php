<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class InternmentProcessRequest extends FormRequest
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
            'application_id'          => 'required|exists:applications,id',
            'custom_agent_id'         => 'required_if:customs_house,false',
            'agent_payment'           => 'nullable|numeric|between:0,999999999999|gt:-1',
            'iva_amt'                 => 'nullable|numeric',
            'adv_amt'                 => 'nullable|numeric',
            'cif_amt'                 => 'nullable|numeric',
            'files'                   => 'nullable|array',
            'files.*'                 => 'nullable|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:2048',
            'file_certificate'        => 'nullable|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:2048',
            'dataLoad'                => 'required_if:transport,true',
            //"dataLoad.*.weight"       => "required_if:transport,true",
            // "dataLoad.*.cbm"          => "required_if:transport,true",
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'application_id.required'   => 'Se debe tener una solicitud generada.'
        ];
    }

    public function attributes()
    {
        return [
            'custom_agent_id'    => 'Agente de aduana',
            'agent_payment'      => 'Monto Total de Operacion',
        ];
    }


}
