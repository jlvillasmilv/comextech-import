<?php

namespace App\Http\Requests\Web\Factoring;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserCredential;

class UpdateCredentialRequest extends FormRequest
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
             'password' => 'required|max:200',
        ];
    }

}
