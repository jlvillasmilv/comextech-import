<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TransCompaniesRequest extends FormRequest
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
        $id = is_null($this->trans_company) ? 0 : $this->trans_company;
        
        $rules = [
            'name'            => 'required|max:100|unique:trans_companies,name,'.$id, 
            'description'     => 'nullable|max:255', 
            'url'             => 'nullable|url',
            'status'          => 'required',            
        ];

        return $rules;
    }
}
