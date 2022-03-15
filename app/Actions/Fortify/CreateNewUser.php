<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\{User, TransCompany, JumpSellerUser};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name'         => ['required', 'string', 'max:150'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tax_id'       => ['required', 'string', 'max:100', 'unique:companies'],
            'company_name' => ['required', 'string', 'max:100'],
            'password' => $this->passwordRules(),
        ])->validate();
        
        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name'     => $input['name'],
                'email'    => $input['email'],
                'password' => $input['password'],
            ]), function (User $user) use ($input) {
                $this->createCompany($user, $input);
            });
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createCompany(User $user, $input)
    {
        $country = \DB::table('countries')->where('code', $input['country'],)->first()->id;

        $country_code = is_null($country) ? 41 : $country;

        $user->assignRole('Client'); //assign role to user
        $user->company()->create([
            'tax_id'        => $input['tax_id'],
            'name'          => $input['company_name'],
            'email'         => $input['email'],
            'contact_name'  => $input['name'],
            'country_id'    => $country_code,
            'status'        => 1
        ]);


        $trans_company  = TransCompany::get();

        foreach ($trans_company as $key => $company) {
            $user->discount()->create([
                'trans_company_id' => $company->id,
                'imp_a' => 60
            ]);
        }

        \DB::table('user_mark_ups')->insert(['user_id' => $user->id,]);

        $data = [
            "customer" => [
                "name"      => $input['name'],
                "surname"   => $input['name'],
                "email"     => $input['email'],
                "phone"     => "00000000",
                "password"  => 'COMEXTECH.'.date('Ymd'),
                "status"    => "approved",
                "billing_addresses" => [
                    [
                         "name"          => $input['name'],
                         "surname"       => $input['name'],
                         "address"       => "...",
                         "city"          => "...",
                         "postal"        => "0000",
                         "country"       => "CL",
                         "region"        => "12",
                         "taxid"         => null,
                         "primary"       => true,
                         "municipality"  => "Las Condes"
                     ]
                ],
            ]
        ];

       $user_jumpseller = JumpSellerUser::createJumpSellerUser($data);

       if(isset($user_jumpseller["id"]) || $user_jumpseller["id"] > 0 )
       {
            $user->jumpSellerUser()->create([
                'customer_id' => $user_jumpseller["id"]
            ]);
       }
    
    }
}
