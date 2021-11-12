<?php

namespace App\Http\Requests\Web\Factoring\Partners;

use App\Models\Factoring\Partner;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateOrCreateRequest extends FormRequest
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
            'company_id' =>'',
            'id'         =>'',
            'last_name'  =>'required',
            'first_name' =>'required', 
            'email'   => [
                    $this->id ? Rule::unique('factoring_partners')->ignore($this->id) :'unique:factoring_partners,email',
                    'required',
                    'email'
            ],
            'address' => 'required',
            'rut'     => [
                $this->id ? Rule::unique('factoring_partners')->ignore($this->id) :'unique:factoring_partners,rut',
                'required'
            ],
        ];
    }

    public function updateOrCreate()
    {
        $response = Partner::updateOrCreate(
            [
                'id'    => $this->id,
            ],
            [   'company_id'  => $this->company_id,
                'first_name'  => $this->first_name,
                'last_name'   => $this->last_name,
                'email'       => $this->email,
                'rut'         => $this->rut,
                'address'     => $this->address
            ],
        );
        return ['partner' => $response, 'id' => $this->id ];
    }
}
