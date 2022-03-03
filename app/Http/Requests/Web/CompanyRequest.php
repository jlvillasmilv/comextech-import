<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $id = is_null($this->company) ? 0 : base64_decode($this->company);

        $rules = [
            'country_id'    => 'required|exists:countries,id',
            'tax_id'        => 'required|max:50|unique:companies,tax_id,' . $id,
            'name'          => 'required|max:100',
            'email'         => 'required|max:250',
            'contact_name'  => 'nullable|max:254',
            'phone'         => 'nullable|max:100',
            'contact_telf'  => 'nullable|max:100',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'country_id'   => 'Pais de origen',
            'name'         => 'Nombre empresa',
            'email'        => 'Correo electronico',
            'contact_name' => 'Representante',
            'contact_telf' => 'Numero de Telefono Representante'
        ];
    }
}
