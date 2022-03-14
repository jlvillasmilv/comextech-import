<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ApplicationPaymentRequest;
use App\Models\{Application, ApplicationPayment, User};
use App\Models\Factoring\Disbursement;
use App\Models\Currency;
use App\Models\JumpSellerAppPayment;
use App\Notifications\CLient\{ValidationCodeNotification, ValidationCodeProcessed};
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

        if ($application_order->authorization_code != $request->authorization_code)
        {
            return response()->json(['error' => 'Codigo Invalido'], 422);
        }

        if($request->available_credit > auth()->user()->company->available_credit || $request->available_credit > $application_order->tco_clp)
        {
            return response()->json(['error' => 'Monto no puede ser mayor a credito o operacion'], 422);
        }

        if($request->available_prepaid > auth()->user()->company->available_prepaid || $request->available_prepaid > $application_order->tco_clp)
        {
            return response()->json(['error' => 'Monto Prepago no puede ser mayor a credito o operacion'], 422);
        }

        if(($request->available_credit + $request->available_prepaid) > $application_order->tco_clp)
        {
            return response()->json(['error' => 'Monto credito no puede ser mayor a total operacion'], 422);
        }

        if (is_null($application_order) || $application_order->tco_clp <= 0) {
            return response()->json(['error' => 'Solicitud no encontrada'], 500);
        }

        ApplicationPayment::addPayment($application_order->id ,$request->all());

        $total = round($application_order->tco_clp - $request->available_credit - $request->available_prepaid, 0);

        if ($total > 0 ) {
            $url_order = "";
            if (!is_null($application_order->duplicate_url)) {

                $jump_seller_order = JumpSellerAppPayment::getSingleOrder($application_order->order_id);
                $url_order =  empty($jump_seller_order["recovery_url"]) ? $jump_seller_order["duplicate_url"] : $jump_seller_order["recovery_url"];

                if ($total != $jump_seller_order["total"] && $jump_seller_order["status"] != 'Paid' )
                { 
                    $jump_seller_modify = JumpSellerAppPayment::modifySingleOrder($application_order->order_id, 'Canceled');
                    $url_order = "";
                }
                
            }

            if (empty($url_order)) {
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

        return response()->json(['credit' => 'Pagado con credito'], 200);
    }

    public function paymentProcces($id)
    {
        //sum of total amount of disbursements status aproved
        $total_amount   = Disbursement::Approved()->select('disbursements.total_amount')->sum('total_amount');

        $total_payment_sii = 0;

        foreach (auth()->user()->application as $key => $app) {
            $total_payment_sii += $app->applicationPayment->where('payment_method_type','PREPAGO SII')->sum('total');
        }

        if(($total_amount - $total_payment_sii ) > 0)
        {
            auth()->user()->company->update(['available_credit' => $total_amount - $total_payment_sii]);
        }

        ApplicationPayment::checkPayment($id);

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
            'jumpSellerAppPayment' => function ($query) {
                $query->select('id','application_id','order_id','duplicate_url','recovery_url', 'checkout_url');
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
       $code = Application::generateUniqueCode($application_id);
       $application = Application::findOrFail($application_id);
       $application->authorization_code = $code;
       $application->save();

       $user = User::findOrFail(auth()->user()->id);

       $user->notify(new ValidationCodeNotification($application));
       
       // notification via whatsapp
       // $user->notify(new ValidationCodeProcessed($application));
       
       return response()->json(['status' => 'OK'], 200);
    }

    public function validateCode($code)
    {

    }

}
