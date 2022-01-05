<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'rate'          => 'required|numeric',
            'mora_rate'     => 'required|numeric',
            'discount'      => 'required|numeric',
            'commission'    => 'required|numeric', 
            'api_sii'       => 'nullable|url',
            'url_video'     => 'nullable|max:250',
            'doc_mgmt_fcl'  => 'required|numeric', 
            'loan_fcl'      => 'required|numeric',
            'gate_in_fcl'   => 'required|numeric',
            'doc_mgmt_lcl'  => 'required|numeric', 
            'doc_visa_lcl'  => 'required|numeric',
            'dispatch_lcl'  => 'required|numeric',  
        ];

        return $rules;
    }
}
