<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
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
        
        $id = is_null($this->bank_account) ? 0 : base64_decode($this->bank_account);
        
        $rules = [
            'bank_id'     => 'required|exists:banks,id',
            'number'      => 'required|max:30|unique:bank_accounts,number,' . $id,
            'status'      => 'required',
        ];

        return $rules;
    }
}
