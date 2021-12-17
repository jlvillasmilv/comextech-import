<?php

namespace App\Http\Requests\Admin\Rates;

use Illuminate\Foundation\Http\FormRequest;

class RateLCLRequest extends FormRequest
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
            "MIN_0_5"       => 'required|numeric',
            "w0_5_TON_M3"   => 'required|numeric',
            "MIN_5_10"      => 'required|numeric',
            "w5_10_TON_M3"  => 'required|numeric',
            "MIN_10_5"      => 'required|numeric',
            "w10_15_TON_M3" => 'required|numeric',
            "oth_exp"       => 'required|numeric',
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
