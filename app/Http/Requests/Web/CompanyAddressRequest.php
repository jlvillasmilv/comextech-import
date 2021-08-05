<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CompanyAddressRequest extends FormRequest
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
            'country_id'    => 'required|exists:countries,id',
            'postal_code'   => 'nullable|max:50',
            'services'      => 'required',
            'place'         => 'required',
            'address'       => 'required|max:254',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'country_id'  => 'Pais de origen',
            'postal_code' => 'Codigo postal',
            'place'       => 'Lugar',
            'address'     => 'Direccion'
        ];
    }
}
