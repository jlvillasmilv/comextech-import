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
            "application_id"    => 'required|exists:applications,id',
            "availablePrepaid"  => 'numeric|gte:0',
            "available_prepaid" => 'numeric|lte:availablePrepaid',
            "availableCredit"   => 'numeric|gte:0',
            "available_credit"  => 'numeric|gte:0|lte:availableCredit',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            "availablePrepaid"  => 'PREPAGO (Cesion SII)',
            "available_prepaid" => 'PREPAGO (Cesion SII)',
            "availableCredit"   => 'CREDITO DISPONIBLE',
            "available_credit"  => 'CREDITO DISPONIBLE',
        ];
    }


}
