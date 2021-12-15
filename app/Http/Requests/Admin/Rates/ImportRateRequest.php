<?php

namespace App\Http\Requests\Admin\Rates;

use Illuminate\Foundation\Http\FormRequest;

class ImportRateRequest extends FormRequest
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
            'file' => ['required', 'max:2000' ,'mimes:csv,xlsx,xls']
        ];
    }

    public function attributes()
    {
        return [
            'file'            => 'Archivo para importar datos',
        ];
    }
}
