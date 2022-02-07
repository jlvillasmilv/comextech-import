<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class JumpSellerAppPayment extends Model
{
    protected $table = 'jump_seller_app_payments';
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

   
    public static function createJumpSellerOrder($data){

        $customer_id = JumpSellerUser::where('user_id', auth()->user()->id)->firstOrFail()->customer_id;

        if (is_null( $customer_id)) {
            return response()->json('Id customer not found', 500);
        } 

        $order = [
            "order" => [
                "status"               => "Pending Payment",
                "shipping_method_id"   => null,
                "shipping_method_name" => null,
                "shipping_price" => 0,
                "customer" => [
                    "id"               => $customer_id,
                    "shipping_address" => null,
                    "billing_address"  => null
                ],
                "products" => [
                    [
                        "id"         => 12841254,
                        "variant_id" => 0,
                        "qty"        => 1,
                        "price"      => $data['qty'],
                        "discount"   => 0
                    ]
                ]
            ]
        ];

        try {
            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/orders.json?login={$login}&authtoken={$auth_token}";
  
            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withBody(json_encode($order), 'application/json')
            ->post($url);

            $obj = json_decode($httpResponse->body(), true);

            if (empty($obj["order"])) { return $obj; }

            JumpSellerAppPayment::create([
                'application_id' => $data['application_id'],
                'order_id'       => $obj["order"]["id"],
                'customer_id'    => $customer_id,
                'status'         => $obj["order"]["status"],
                'duplicate_url'  => $obj["order"]["duplicate_url"],
                'recovery_url'   => $obj["order"]["recovery_url"],
                'checkout_url'   => $obj["order"]["checkout_url"]
            ]);

            return $obj["order"];
      
        } catch (\Throwable $th) {
            return response()->json('Id customer not found', 500);
        }

    }
}
