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

    /**
     * @author Jorge Villasmil.
     *
     * Generate a new Order JumpSeller API.
     *
     * @param  array  $data
     * https://jumpseller.cl/support/api/#tag/Orders/paths/~1orders.json/post
     *
    */
    public static function createJumpSellerOrder($data)
    {
        $customer_id = JumpSellerUser::where('user_id', auth()->user()->id)->firstOrFail()->customer_id;

        if (is_null($customer_id)) {
            return response()->json('Id customer not found', 500);
        }
        
        //check available Pending Payment and change status to Canceled
        $pending_payment = JumpSellerAppPayment::where([
            ['customer_id', $customer_id],
            ['status', 'Pending Payment']
            ])
            ->get();
            
        foreach ($pending_payment as $key => $pending_order) {
            $jump_seller_modify = JumpSellerAppPayment::modifySingleOrder($pending_order->order_id, 'Canceled');
        }

        //check available variant variant_id product
        $variant_id = JumpSellerAppPayment::variantProduct();

        if ($variant_id <= 0) {
            return response()->json('Product not found', 500);
        }

        //update variant variant_id product
        $up_variant_id = JumpSellerAppPayment::UpdateVariantProduct($variant_id, $data);

        if (!empty($up_variant_id["message"])) {
            return response()->json($up_variant_id["message"], 404);
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

            if (empty($obj["order"])) {
                return $obj;
            }

            JumpSellerAppPayment::updateOrCreate(
                [  'application_id' => $data['application_id'] ],
                [
                'order_id'       => $obj["order"]["id"],
                'variant_id'     => $variant_id,
                'customer_id'    => $customer_id,
                'status'         => $obj["order"]["status"],
                'duplicate_url'  => $obj["order"]["duplicate_url"],
                'recovery_url'   => $obj["order"]["recovery_url"],
                'checkout_url'   => $obj["order"]["checkout_url"]
            ]
            );

            return $obj["order"];
        } catch (\Throwable $th) {
            return response()->json('Id customer not found', 500);
        }
    }

    /**
     *
     * Retrieve a single Order from JumpSeller API.
     *
     * @param  Integer  $id
     * https://jumpseller.cl/support/api/#tag/Orders/paths/~1orders.json/post
     *
    */
    public static function getSingleOrder($id)
    {
        try {
            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/orders/{$id}.json?login={$login}&authtoken={$auth_token}";

            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->get($url);

            $obj = json_decode($httpResponse->body(), true);

            if (empty($obj["order"])) {
                return $obj;
            }

            return $obj["order"];
        } catch (\Throwable $th) {
            return response()->json('Id customer not found', 500);
        }
    }

    /**
    *
    * Modify an existing Order from JumpSeller API.
    *
    * @param  Integer $id
    * @param  String  $status
    * https://jumpseller.cl/support/api/#tag/Orders/paths/~1orders~1{id}.json/put
    *
    */
    public static function modifySingleOrder($id, $status)
    {
        $order =  [
            "order" => [
                "status"           => $status,
                "shipment_status"  => null,
                "tracking_number"  => null,
                "tracking_company" => null,
                "tracking_url"     => null,
                "additional_information" => null,
                "additional_fields" => []
            ]
        ];

        try {
            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/orders/{$id}.json?login={$login}&authtoken={$auth_token}";

            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->withBody(json_encode($order), 'application/json')
            ->put($url);

            $obj = json_decode($httpResponse->body(), true);

            if (empty($obj["order"])) {
                return $obj;
            }

            JumpSellerAppPayment::where('order_id', $id)->update(['status' => $status]);

            return $obj["order"];
        } catch (\Throwable $th) {
            return response()->json('Id customer not found', 500);
        }
    }

    /**
     *
     * Retrieve all Product Variants JumpSeller API.
     * https://jumpseller.cl/support/api/#tag/Product-Variants/paths/~1products~1{id}~1variants~1{variant_id}.json/get
     *
    */
    public static function variantProduct()
    {
        try {
            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/products/12841254/variants.json?login={$login}&authtoken={$auth_token}";
  
            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->get($url);

            $obj = json_decode($httpResponse->body(), true);

            if (empty($obj[0]["variant"]["id"])) {
                return JumpSellerAppPayment::CreateVariantProduct();
            }
            
            $variants_id = array();

            $status_order = ['Canceled','Paid'];

            foreach ($obj as $key => $item) {
                $variants_id[] = $item["variant"]['id'];
                $busy_variant_id = JumpSellerAppPayment::where('variant_id', $item["variant"]['id'])
                ->whereNotIn('status', $status_order)
                ->first();

                if (is_null($busy_variant_id)) {
                    return $item["variant"]['id'];
                }
            }

            return JumpSellerAppPayment::CreateVariantProduct();
        } catch (\Throwable $th) {
            return $th;
        }
    }


    /**
     *
     * Create a new Product Variant JumpSeller API.
     * https://jumpseller.cl/support/api/#tag/Product-Variants/paths/~1products~1{id}~1variants.json/post
     *
    */
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

            if (empty($obj["variant"]["id"])) {
                return null;
            }

            return $obj["variant"]["id"];
        } catch (\Throwable $th) {
            return response()->json('Id variant not found', 500);
        }
    }


    /**
     * @author Jorge Villasmil.
     *
     * Modify an existing Product Variant JumpSeller API.
     * https://jumpseller.cl/support/api/#tag/Product-Variants/paths/~1products~1{id}~1variants~1{variant_id}.json/put
     * @param  int  $id
     * @param  array  $data
    */
    public static function UpdateVariantProduct($id=null, $data)
    {
        try {
            $login = env('JUMPSELLER_LOGIN');
            $auth_token = env('JUMPSELLER_AUTH_TOKEN');
            $url = "https://api.jumpseller.com/v1/products/12841254/variants/{$id}.json?login={$login}&authtoken={$auth_token}";

            $httpResponse = Http::withHeaders(['Content-Type' => 'application/json'])
            ->get($url);

            $obj = json_decode($httpResponse->body(), true);

           
            if (empty($obj["variant"]["id"])) {
                return $obj;
            }

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

            if (empty($obj["variant"]["id"])) {
                return $obj;
            }

            JumpSellerAppPayment::UpdateVariantOptionProduct($obj, $data['application_code']);

            return $obj["variant"]["id"];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
       * @author Jorge Villasmil.
       *
       * Modify an existing Product Option Value. JumpSeller API.
       * https://jumpseller.cl/support/api/#tag/Product-Option-Values/paths/~1products~1{id}~1options~1{option_id}~1values~1{value_id}.json/put
       *
       * @param  array  $data
       * @param  string $name
    */
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

            if (empty($obj["value"]["id"])) {
                return $obj;
            }

            return $obj["value"]["id"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
