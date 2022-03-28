<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = is_null($this->users_company) ? 0 : $this->users_company;

        $rules = [
            'name'             => 'required|max:100',
            'email'            => 'required|email|max:100|unique:users,email,'.$id,         
            'password'         => 'required|min:6|max:20',            
        ];

        return $rules;
    }
}
