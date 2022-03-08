<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ApplicationPaymentRequest;
use App\Models\{Application, ApplicationPayment};
use App\Models\Currency;
use App\Models\JumpSellerAppPayment;
use App\Notifications\CLient\ValidationCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentApplicationController extends Controller
{
    public function generateOrder(ApplicationPaymentRequest $request)
    {
        //dd($request->all());
        $application_order = \DB::table('applications as app')
        ->leftjoin('jump_seller_app_payments as jsap', 'jsap.application_id', '=', 'app.id')
        ->where([
            ["app.id", $request->application_id],
            ["app.user_id", auth()->user()->id]
        ])
        ->select('app.*', 'jsap.application_id', 'jsap.order_id', 'jsap.duplicate_url', 'jsap.recovery_url', 'jsap.checkout_url', 'jsap.status')
        ->first();

        //    dd($application_order);

        if (is_null($application_order) || $application_order->tco_clp <= 0) {
            return response()->json('Solicitud no encontrada', 500);
        }

        if (!is_null($application_order->duplicate_url)) {
            // $url_order =  is_null($application_order->recovery_url) ? $application_order->checkout_url : $application_order->recovery_url;
            $url_order = $application_order->checkout_url;
        }

        $data_payment = [
                ['payment_method_type' => 'PREPAGO SII', 'total' => $request->available_prepaid ],
                ['payment_method_type' => 'CREDITO', 'total' => $request->available_credit ],
        ];
    
        ApplicationPayment::addPayment($application_order->id ,$data_payment);

        $total = round($application_order->tco_clp - $request->available_credit - $request->available_prepaid, 0);

        if ($total > 0 && $application_order->status != 'Paid') {
            if (is_null($application_order->recovery_url) && is_null($application_order->duplicate_url)) {
                $data = [
                    "application_id"      => $application_order->id,
                    "application_code"    => $application_order->code,
                    "price"               => $total
                    ];

                $url = JumpSellerAppPayment::createJumpSellerOrder($data);

                if (!empty($url["message"])) {
                    return response()->json($url["message"], 500);
                }

                $url_order = $url["checkout_url"];
            }
        
            return response()->json(['order' => $url_order], 200);
        }
    }

    public function paymentProcces($id)
    {
        $data  = Application::where([
            ['id', $id],
            ['user_id', auth()->user()->id],
        ])
        ->select(
            'id',
            'code',
            'user_id',
            'supplier_id',
            'type_transport',
            'services_code',
            'tco',
            'currency_tco',
            'tco_clp',
            'ecommerce_id',
            'ecommerce_url',
            'condition',
            'services_code'
        )
        ->with([
            'user' => function ($query) {
                $query->select('id')->with([
                    'company'  => function ($query) {
                        $query->select('id', 'user_id', 'available_prepaid', 'available_credit');
                    }
                ]);
            },
            'currencyTco'
        ])
        ->firstOrFail()->toArray();

        $category = \DB::table('application_summaries as appsu')
        ->where('appsu.application_id', $data['id'])
        ->join('category_services as cs', 'appsu.category_service_id', 'cs.id')
        ->groupBy('cs.name')
        ->select('cs.name', DB::raw('SUM(appsu.amount2) as total'))
        ->get()->toArray();

        if ($data['currency_tco']['code'] != 'CLP') {
            foreach ($category as $key => $item) {
                $exchange = new Currency;
                $amount = $exchange->convertCurrency($item->total, $data['currency_tco']['code'], 'CLP');

                $category[$key]->total = $amount;
            }
        }

        $data['summary'] = $category;
        
        return response()->json($data, 200);
    }

    public function generateCode($application_id)
    {
        

    }

    public function validateCode()
    {

    }

}
