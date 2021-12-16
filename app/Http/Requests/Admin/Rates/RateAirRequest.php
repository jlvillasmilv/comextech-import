<?php

namespace App\Http\Requests\Admin\Rates;

use Illuminate\Foundation\Http\FormRequest;

class RateAirRequest extends FormRequest
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
            "from"          => "required",
            "to"            => "required",
            "via"           => "required",
            "t_time"        => 'required|numeric',
            "valid_from"    => 'required|date',
            "valid_to"      => 'required|date|after_or_equal:valid_from',
        ];
    }

    public function attributes()
    {
        return [
            "from"          => "Origen",
            "to"            => "destino",
            "t_time"        => 'Tiempo de transito',
            "valid_from"    => 'Fecha inicio',
            'valid_to'      => 'Fecha limite',
        ];
    }
}
