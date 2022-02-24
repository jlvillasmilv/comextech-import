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

        $variant_id = JumpSellerAppPayment::variantProduct();

        if ($variant_id <= 0) { return response()->json('Product not found', 500); }

        $up_variant_id = JumpSellerAppPayment::UpdateVariantProduct($variant_id, $data);

        if (!empty($up_variant_id["message"])) { return response()->json($up_variant_id["message"], 404); }

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
                        "variant_id" => $variant_id,
                        "qty"        => 1,
                        "price"      => $data['price'],
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
                'variant_id'     => $variant_id,
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

    public static function variantProduct()
    {
        try {

            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/products/12841254/variants.json?login={$login}&authtoken={$auth_token}";
  
            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->get($url);

            $obj = json_decode($httpResponse->body(), true);

            if (empty($obj[0]["variant"]["id"])) { return JumpSellerAppPayment::CreateVariantProduct(); }
            
            $variants_id = array();

            $status_order = ['Canceled','Paid'];

            foreach ($obj as $key => $item){
                $variants_id[] = $item["variant"]['id'];
                $busy_variant_id = JumpSellerAppPayment::where('variant_id',$item["variant"]['id'])
                ->whereNotIn('status', $status_order)
                ->first();

                if(is_null($busy_variant_id)){  return $item["variant"]['id']; }

            }

            return JumpSellerAppPayment::CreateVariantProduct();

        } catch (\Throwable $th) {

            return $th;
        }

    }


    public static function CreateVariantProduct()
    {
        try {

            $variant = [
                "variant" => [
                    "price" => 1,
                    "sku"   => date('YmdHms'),
                    "stock" => 1,
                    "stock_unlimited" => true,
                    "options" => [
                        [
                          "name"  => "TRANSPORTE",
                          "value" => "IMPORT".date('YmdHms')
                        ]
                      ]
                ]
            ];

            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/products/12841254/variants.json?login={$login}&authtoken={$auth_token}";
  
            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withBody(json_encode($variant), 'application/json')
            ->post($url);

            $obj = json_decode($httpResponse->body(), true);

            if (empty($obj["variant"]["id"])) { return null; }

            return $obj["variant"]["id"];

        } catch (\Throwable $th) {
            return response()->json('Id variant not found', 500);
        }

    }

    public static function UpdateVariantProduct($id=null, $data)
    {
        try {

            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/products/12841254/variants/{$id}.json?login={$login}&authtoken={$auth_token}";

            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->get($url);

            $obj = json_decode($httpResponse->body(), true);

           
            if (empty($obj["variant"]["id"])) { return $obj; }

            // dd($obj["variant"]["options"][0]["product_option_id"]);

            $variant = [
                "variant" => [
                    "price" => $data['price'],
                    "sku"   => date('YmdHms'),
                    "stock" => 1,
                    "stock_unlimited" => true,
                    "options" => [
                        [
                            "product_option_id"       => $obj["variant"]["options"][0]["product_option_id"],
                            "product_option_value_id" => $obj["variant"]["options"][0]["product_option_value_id"],
                            "name"                    => $obj["variant"]["options"][0]["name"],
                            "value"                   => $data['application_code'],
                            "product_option_position" => 0,
                            "product_value_position"  => 0
                        ]
                      ]
                ]
            ];
  
            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withBody(json_encode($variant), 'application/json')
            ->put($url);

            $obj = json_decode($httpResponse->body(), true);

            if (empty($obj["variant"]["id"])) { return $obj; }

            JumpSellerAppPayment::UpdateVariantOptionProduct($obj,$data['application_code']);

            return $obj["variant"]["id"];
            

        } catch (\Throwable $th) {
            
            return $th;
        }

    }


    public static function UpdateVariantOptionProduct($data, $name = null)
    {
        try {

            $product_option_id = $data["variant"]["options"][0]["product_option_id"];
            $product_option_value_id = $data["variant"]["options"][0]["product_option_value_id"];

            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/products/12841254/options/{$product_option_id}/values/{$product_option_value_id}.json?login={$login}&authtoken={$auth_token}";

            $option_variant = [
                "value" => [
                    "name"       => $name,
                    "position"   => 0
                ]
            ];

            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withBody(json_encode($option_variant), 'application/json')
            ->put($url);

            $obj = json_decode($httpResponse->body(), true);

            if (empty($obj["value"]["id"])) { return $obj; }

            return $obj["value"]["id"];

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}
