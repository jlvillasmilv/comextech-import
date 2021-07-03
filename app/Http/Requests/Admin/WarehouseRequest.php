<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
        $id = is_null($this->warehouse) ? 0 : $this->warehouse;
        
        $rules = [
            'name'            => 'required|max:100|unique:warehouses,name,'.$id, 
            'postal_code'     => 'required|max:10', 
            'phone_number'    => 'nullable|max:50',
            'address'         => 'nullable|string',    
            'status'          => 'required',            
        ];

        return $rules;
    }
}
