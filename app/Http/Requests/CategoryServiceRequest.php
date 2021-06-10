<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryServiceRequest extends FormRequest
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
        $id = is_null($this->category_service) ? 0 : $this->category_service;
        
        $rules = [
            'name'               => 'required|max:100|unique:category_services,name,' . $id,
            'description'        => 'nullable|max:250',
        ];

        return $rules;
    }
}
