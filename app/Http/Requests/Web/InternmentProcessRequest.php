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
        return [
            'application_id'          => 'required|exists:applications,id',
            'agent_name'              => 'required_if:customs_house,false|max:250',
            'agent_payment'           => 'nullable|numeric|between:1,999999999999|gt:0',
            'files'                   => 'nullable|array',
            'files.*'                 => 'nullable|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:2048',
            'file_certificate'        => 'nullable|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:2048',
            'dataLoad'                => 'required_if:transport,false',
            //"dataLoad.*.weight"       => "required_if:transport,false|numeric",
        ];
    }

    public function messages()
    {
        return [
            'application_id.required'   => 'Se debe tener una solicitud generada.',
            'agent_name.required_if'    => 'El campo Nombre del Agente de aduana es obligatorio.',
            'agent_payment.between'     => 'El campo Monto Total de Operacion debe ser menor a 999.999.999.999' ,
        ];
    }
}
