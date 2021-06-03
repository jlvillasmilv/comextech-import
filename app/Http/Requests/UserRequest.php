<?php

namespace App\Http\Requests;

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
        $id = is_null($this->user) ? 0 : $this->user;

        $rules = [
            'name'             => 'required|max:100',
            'avatar'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email'            => 'required|email|max:100|unique:users,email,'.$id,         
            'password'         => 'required',            
        ];

        return $rules;

    }
}
