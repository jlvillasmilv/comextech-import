<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        $id = is_null($this->company) ? 0 : $this->company;
        
        $rules = [
            'category_service_id'  => 'required|exists:category_services,id',
            'name'                 => 'required|max:100',
            'description'          => 'nullable|max:250',
        ];

        return $rules;
    }
}
