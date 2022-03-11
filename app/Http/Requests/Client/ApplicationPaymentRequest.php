<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationPaymentRequest extends FormRequest
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
            "application_id"     => 'required|exists:applications,id',
            "available_prepaid"  => 'numeric',       //lte:availablePrepaid
            "available_credit"   => 'numeric|gte:0', //lte:availableCredit
            "authorization_code" => 'required'
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            "authorization_code" => 'Codigo de validacion firma',
            "available_prepaid" => 'PREPAGO (Cesion SII)',
            "available_credit"  => 'CREDITO DISPONIBLE',
        ];
    }


}
