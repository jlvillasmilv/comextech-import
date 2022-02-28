<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class JumpSellerUser extends Model
{
    protected $table = 'jump_seller_users';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasMany(JumpSellerAppPayment::class, 'customer_id');
    }

     /**
     * Create a new Customer API JumpSeller..
     *
     * @param  array  $data
     * @return void
     */
    public static function createJumpSellerUser($data){

        $customer = JumpSellerUser::singleCustomerEmail($data['customer']['email']);
       
        if(isset($customer["id"]) && $customer["id"] > 0 ) { return $customer; }

        $login = env('JUMPSELLER_LOGIN');
        $auth_token = env('JUMPSELLER_AUTH_TOKEN');

        try {
            $url = "https://api.jumpseller.com/v1/customers.json?login={$login}&authtoken={$auth_token}";
           
            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withBody(json_encode($data), 'application/json')
            ->post($url);

            $obj = json_decode($httpResponse->body(), true);

            return isset($obj["customer"]) ? $obj["customer"] : ["id" => 0];

        } catch (\Throwable $th) {
           return $th;
        }

    }
    
     /**
     * Retrieve a single Customer by email.
     *
     * @param  string  $email
     * @return void
     */
    public static function singleCustomerEmail($email){

        $login = env('JUMPSELLER_LOGIN');
        $auth_token = env('JUMPSELLER_AUTH_TOKEN');

        try {

            $url = "https://api.jumpseller.com/v1/customers/email/{$email}.json?login={$login}&authtoken={$auth_token}";
           
            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->get($url);

            $obj = json_decode($httpResponse->body(), true);

            return isset($obj["customer"]) ? $obj["customer"] : ["id" => 0];

        } catch (\Throwable $th) {
           return $th;
        }

    }

    
}
