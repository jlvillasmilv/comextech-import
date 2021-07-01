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
            'agent_payment'           => 'nullable|numeric',
            'files'                   => 'nullable|array',
            'files.*'                 => 'nullable|max:2048',
            'dataLoad'                => 'required_if:transport,false',
            //"dataLoad.*.weight"       => "required_if:transport,false|numeric",
        ];
    }
}
