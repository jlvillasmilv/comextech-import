<?php

namespace App\Http\Controllers\Web;

use App\Models\services\DHL;
use App\Models\{Transport, Load, Service, FedexApi, ApplicationDetail, Currency, User};
use App\Notifications\TransportRateNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\Web\TransportRequest;


class TransportsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function ports($type)
    {
          $ports = \DB::table('ports as sp')
                      ->join('countries as c', 'sp.country_id', '=', 'c.id')
                      ->where('sp.status', true)
                      ->where('sp.type', $type)
                      ->select('sp.id', \DB::raw("CONCAT(sp.name,' ',c.name,' (', sp.unlocs,')') AS name"))
                      ->orderBy('sp.id')
                      ->get();
          
          return response()->json($ports, 200);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function portSupplier($id, $type)
    {
          $ports = \DB::table('ports_suppliers as ps')
                      ->join('ports as p', 'ps.port_id', '=', 'p.id')
                      ->join('countries as c', 'p.country_id', '=', 'c.id')
                      ->where('p.status', true)
                      ->where('p.type', $type)
                      ->where('ps.supplier_id' , $id) 
                      ->select('p.id', \DB::raw("CONCAT(p.name,' ',c.name,' (', p.unlocs,')') AS name"))
                      ->orderBy('p.id')
                      ->get();
          
          return response()->json($ports, 200);
    }

     /**
     * Display a list port user selected.
     *
     * @return \Illuminate\Http\Response
     */
    public function portUser($type)
    {
          $ports = \DB::table('ports_users as ps')
                      ->join('ports as p', 'ps.port_id', '=', 'p.id')
                      ->join('countries as c', 'p.country_id', '=', 'c.id')
                      ->where('p.status', true)
                      ->where('p.type', $type)
                      ->where('ps.user_id' , auth()->user()->id) 
                      ->select('p.id', \DB::raw("CONCAT(p.name,' ',c.name,' (', p.unlocs,')') AS name"))
                      ->orderBy('p.id')
                      ->get();
          
          return response()->json($ports, 200);
    }

    /**
     * @author Jorge Villasmil.
     * 
     * Generate a new or Update Transport register in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
    */
    public function add(TransportRequest $request)
    { 
        DB::beginTransaction();
        try {
                      
            $transport =  Transport::updateOrCreate(
                [
                    'application_id'   => $request->application_id,
                ],
                [
                    'trans_company_id'      => $request->trans_company_id,
                    'mode_selected'         => $request->mode_selected,
                    
                    'fav_origin_address'    => $request->fav_origin_address,
                    'origin_address'        => $request->origin_address,
                    'origin_postal_code'    => $request->origin_postal_code,
                    'origin_ctry_code'      => $request->origin_ctry_code,
                    'fav_origin_port'       => $request->fav_origin_port,
                    'origin_port_id'        => $request->origin_port_id,
                   
                    'fav_dest_address'      => $request->fav_dest_address,
                    'dest_address'          => $request->dest_address,
                    'fav_dest_port'         => $request->fav_dest_port,
                    'dest_port_id'          => $request->dest_port_id,
                    'dest_postal_code'      => $request->dest_postal_code,
                    'dest_ctry_code'        => $request->dest_ctry_code,
                    'dest_locality'         => $request->dest_locality,
                    'dest_province'         => $request->dest_province,
                    
                    'estimated_date'        => $request->estimated_date,
                    'insurance'             => $request->insurance,
                ]
            );

            Load::cargo($request->input('dataLoad'),$request->application_id);

            $transport_amount = is_null($request->app_amount) ? 0 : $request->app_amount;

            $rate_insurance_transp = \DB::table('settings')->first(['min_rate_transp'])->min_rate_transp;

            $amount = $transport->application->amount;

            if($transport->application->currency->code != 'USD'){

                $exchange = New Currency;
                $amount = $exchange->convertCurrency($transport->application->amount, $transport->application->currency->code, 'USD');

            }


            $cif = $amount + $transport_amount;
            $oth_exp  = 0;
            $fee_date = $request->estimated_date;
            $local_transp = 0;
            $from_port_transport = '';
            $to_port_transport   = '';

            //data calculate other expenses courier

            if($transport->application->type_transport == "COURIER")
            {
                $data = [
                        'application_id'     => $request->application_id,
                        'trans_company_id'   => $transport->trans_company_id,
                        'amount'             => $amount,
                ];

                Transport::rateLocalCourierExpenses($data);
            }


            $insurance_amount = $cif * 0.003 > $rate_insurance_transp ? $cif * 0.003 : $rate_insurance_transp;

            if($transport->application->type_transport == "AEREO" || $transport->application->type_transport == "CONTAINER" || $transport->application->type_transport == "CONSOLIDADO")
            {
                $data = [
                    'commodity'      => $amount,
                    'from'           => $transport->originPort->unlocs,
                    'to'             => $transport->destPort->unlocs,
                    'type_transport' => $transport->application->type_transport,
                    'weight'         => $transport->application->loads->sum('weight')/1000,
                    'cargo'          => $transport->application->loads,
                ];
                
                $transp = Transport::rateTransport($data);


                if($request->dest_port_id > 0 && strlen($request->dest_address) > 0)
                {
                    $local_transp = Transport::rateLocalTransport($request->only([
                        'dest_port_id,',
                        'dest_province',
                        'dest_address',
                        'fav_dest_address',
                        'dataLoad',
                        'mode_selected'
                    ]));

                }

                $transport_amount  = $transp['int_trans'];
                $cif               = $transp['cif'];
                $oth_exp           = $transp['oth_exp'];
                $t_time            = $transp['t_time'];
                $insurance_amount  = $transp['insurance'];
                $currency_id       = 1;
              
                $fee_date = date('Y-m-d', strtotime($request->estimated_date. ' + '.$t_time.' day'));

            }


            // update application summary International transport
            $app_summ = \DB::table('application_summaries as as')
            ->join('services as s', 'as.service_id', '=', 's.id')
            ->where([
               ["as.application_id", $request->application_id],
               ["s.code", 'CS03-01']
               ])
            ->update([
                    'amount'      =>  $transport_amount,
                    'currency_id' =>  8, 
                    'fee_date'    => $fee_date
                ]);

          
                // update application summary insurance
            $app_summ = \DB::table('application_summaries as as')
                ->join('services as s', 'as.service_id', '=', 's.id')
                ->where([
                ["as.application_id", $request->application_id],
                ["s.code", 'CS03-02']
                ])
                ->update([
                    'amount'      => $request->insurance ? $insurance_amount : 0,
                    'currency_id' =>  8,
                    'fee_date'    => $request->estimated_date]);

            // update application summary other expenses
                \DB::table('application_summaries as as')
                    ->join('services as s', 'as.service_id', '=', 's.id')
                    ->where([
                        ["as.application_id", $request->application_id],
                        ["s.code", 'CS06-02']
                    ])
                ->update(['amount' =>  $oth_exp,  'currency_id' =>  1, 'fee_date' => $request->estimated_date]);

             // update application summary local transport
             \DB::table('application_summaries as as')
                ->join('services as s', 'as.service_id', '=', 's.id')
                ->where([
                    ["as.application_id", $request->application_id],
                    ["s.code", 'CS06-01']
                ])
             ->update(['amount' =>  $local_transp,  'currency_id' =>  1, 'fee_date' => $request->estimated_date]);

            $trans_summary = [
                'transport_amount' => round($transport_amount, 2),
                'cif'       => $cif,       
                'oth_exp'   => $oth_exp,  
                'insurance' => $request->insurance ?  round($insurance_amount, 2) : 0,
                'local_transp' => round($local_transp, 2)
            ];

        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => $e], 500);
        }
        return response()->json(['loads' => $transport->application->loads, 'transport' => $trans_summary], 200);

    }


     /**
     * @author Jorge Villasmil.
     * 
     * Connect with Fedex, dhl apis
     * get data from Fedex quote and rate api
     *  
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
    */
    public function fedexRate(TransportRequest $request)
    {
         try {

           if($request->has('dataLoad.0.length') && $request->has('dataLoad.0.width') && $request->has('dataLoad.0.height')) 
           {   
                //Fedex API
                $connect = new FedexApi;
                $fedex_response = $connect->rateApi($request->except(['id','application_id','code_serv']));

                if (!empty($fedex_response->HighestSeverity) && $fedex_response->HighestSeverity == "ERROR") {
                    $notifications = array();
                    foreach ($fedex_response->Notifications as $key => $notification) {
                            $notifications[] = $notification->Message;
                    }
                    return response()->json(['message' => "The given data was invalid.", 'errors' => ['fedex' => $notifications]], 422);
                }

                $quote = array();
                $quote = $fedex_response['PREFERRED_ACCOUNT_SHIPMENT'];

                if(!empty($fedex_response['PREFERRED_ACCOUNT_SHIPMENT'])){

                    // obtaining discount %
                    $discount = auth()->user()
                    ->discountImport($request->except(['id','application_id','code_serv']),'FEDEX');

                    $quote['DeliveryTimestamp'] = $fedex_response['DeliveryTimestamp'];
                    $quote['ServiceType']       = ucwords(strtolower(\Str::replace('_', ' ',$fedex_response['ServiceType'])));

                    /* Calculating the discount on the estimated total */
                    $quote['Discount']          = round(($quote['TotalBaseCharge'] * $discount) / 100, 2);

                    /* Applying the discount on the estimated total */
                    $quote['TotalEstimed'] =  $quote['TotalBaseCharge'] - $quote['Discount'];
                    
                    foreach ($fedex_response['PREFERRED_ACCOUNT_SHIPMENT']['Surcharges'] as $key => $item) {
                        $quote[$item->SurchargeType] = $item->Amount->Amount;
                        /* Applying the discount on the estimated total */
                        $quote['TotalEstimed'] = round($quote['TotalEstimed'] + $item->Amount->Amount, 2);
                    }
            
                    return response()->json($quote, 200);
                }
            }
            else{
                return response()->json(['message' => "Datos invalidos", 'errors' => ['fedex' => 'No data']], 422);
            }

         } catch (\Exception $e) {
             return response()->json(['status' => $e], 500);
         }

    }

    /**
     * @author Jorge Villasmil.
     * 
     * Connect with dhl apis 
     * get data from DHL quote and rate api 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
    */
    public function dhlQuote(TransportRequest $request)
    {
       try {
            if($request->has('dataLoad.0.length') && $request->has('dataLoad.0.width') && $request->has('dataLoad.0.height')) 
            {   
                $connect = new DHL;
                $api = $connect->quoteApi($request->except(['id','application_id','code_serv']));
                $objJsonDocument = json_encode($api);
                $arrOutput = json_decode($objJsonDocument, TRUE);

                // validate data from DHL return errors
                if (!empty($arrOutput['GetQuoteResponse']['BkgDetails']) && !empty($arrOutput['Note'])) {
                    $notifications = array();
                   
                    $notifications['ConditionData'] = $notification['ConditionData'];
                    return response()->json(['message' => "The given data was invalid.", 'errors' => ['dhl' => $notifications]], 422);
                }

                $quote = array();
               
                // validate data from DHL
                if (!empty($arrOutput['GetQuoteResponse']['BkgDetails'])) {
                    // obtaining discount %
                    $discount = auth()->user()
                    ->discountImport($request->except(['id','application_id','code_serv']),'DHL');

                    $total__net_charge =  $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['WeightCharge'] + 
                    $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['TotalDiscount'][0];

                    $quote['ProductShortName']  = ucwords(strtolower($arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['ProductShortName']));
                    $quote['DeliveryDate']      = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['DeliveryDate'];
                    $quote['DeliveryTime']      = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['DeliveryTime'];
                    $quote['PickupCutoffTime']  = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['PickupCutoffTime'];
                    $quote['BookingTime']       = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['BookingTime'];
                    $quote['WeightCharge']      = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['WeightCharge'];
                    $quote['TotalDiscount']     = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['TotalDiscount'][0];
                    $quote['TotalTaxAmount']    = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['TotalTaxAmount']; 
                    $quote['ShippingCharge']    = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['ShippingCharge']; 
                    $quote['Discount']          = $discount;
                    
                    $total_discount = ($total__net_charge * $discount) / 100;

                    /* Calculating the discount on the estimated total */
                    $total =  $total__net_charge - $total_discount;
                    
                    foreach ($arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['QtdShpExChrg'] as $key => $qtdShp_exchrg) {
                        $quote[$qtdShp_exchrg['GlobalServiceName']] = $qtdShp_exchrg['ChargeValue'];
                       /* Calculating the discount on the estimated total */
                        $total = $total + $qtdShp_exchrg['ChargeValue'];
                    }
                    $quote['ComextechTotal']    =  round($total, 2);
                    $quote['ComextechDiscount'] =  round($total_discount, 2);
                }
                
                return response()->json($quote, 200);

            }
        } catch (\Exception $e) {
            return response()->json(['status' => $e], 500);
        }
    }

    public function sendNotification(Request $request) {

        $application =  \DB::table('applications')->where('id', $request->application_id)->first();

        /****Send notification to admin about new applications**/
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name','=', 'Admin');
        })->pluck('id');

        
        $details = [
            'title' => 'Usuario '. auth()->user()->name.' ('.auth()->user()->company->name.')',
            'body'  => 'Solicita cotizacion de transporte para solicitud '.$application->code
        ];

        User::all()
            ->whereIn('id', $admin)
            ->each(function (User $user) use ($application, $details) {
                $user->notify(new TransportRateNotification($application));
                \Mail::to($user->email)->send(new \App\Mail\Factoring\ApplicationReceived($details));
        });
        
        return response()->json(['status' => 200]);

    }
    // TEST API RATE FEDEX DHL
    public function test()
    {
        $data = [
            "fav_origin_address" => true,
            "origin_address" => "1",
            "origin_latitude" => null,
            "origin_longitude" => null,
            "origin_postal_code" => null,
            "origin_locality" => null,
            "origin_ctry_code" => null,
            "fav_dest_address" => true,
            "dest_address" => "1",
            "dest_latitude" => null,
            "dest_longitude" => null,
            "dest_postal_code" => null,
            "dest_locality" => null,
            "dest_ctry_code" => null,
            "insurance" => false,
            "estimated_date" => "2021-10-20",
            "description" => "Carga",
            "type_transport" => "CARGA AEREA",
            "dataLoad" => [
               [
                "mode_calculate" => true,
                "type_load" => 1,
                "type_container" => 1,
                "length" => 30,
                "width"  => 30,
                "height" => 30,
                "length_unit" => "CM",
                "id" => 0,
                "cbm" => 0.1728,
                "weight" => 16,
                "weight_units" => "KG",
                "stackable" => false
               ],
               
            ]
        ];

        $connect = new DHL;
        $api = $connect->quoteApi($data);

        $objJsonDocument = json_encode($api);
        $arrOutput = json_decode($objJsonDocument, TRUE);

        $quote = array();

        if (!empty($arrOutput['GetQuoteResponse']['BkgDetails']) && !empty($arrOutput['Note'])) {
            $notifications = array();
           
            $notifications['ConditionData'] = $notification['ConditionData'];
            return response()->json(['message' => "The given data was invalid.", 'errors' => ['dhl' => $notifications]], 422);
        }

       

        if (!empty($arrOutput['GetQuoteResponse']['BkgDetails'])) {
            $discount = auth()->user()->discountImport($data,'DHL');
            $total__net_charge =  $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['WeightCharge'] + 
            $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['TotalDiscount'][0];

            $quote['ProductShortName']  = ucwords(strtolower($arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['ProductShortName']));
            $quote['DeliveryDate']      = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['DeliveryDate'];
            $quote['DeliveryTime']      = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['DeliveryTime'];
            $quote['PickupCutoffTime']  = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['PickupCutoffTime'];
            $quote['BookingTime']       = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['BookingTime'];
            $quote['WeightCharge']      = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['WeightCharge'];
            $quote['TotalDiscount']     = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['TotalDiscount'][0];
            $quote['TotalTaxAmount']    = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['TotalTaxAmount']; 
            $quote['ShippingCharge']    = $arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['ShippingCharge']; 
            $quote['Discount']          = $discount;
            
            $total_discount = ($total__net_charge * $discount) / 100;

            $total =  $total__net_charge - $total_discount;
            
            foreach ($arrOutput['GetQuoteResponse']['BkgDetails']['QtdShp']['QtdShpExChrg'] as $key => $qtdShp_exchrg) {
                $quote[$qtdShp_exchrg['GlobalServiceName']] = $qtdShp_exchrg['ChargeValue'];
                $total = $total + $qtdShp_exchrg['ChargeValue'];
            }

            $quote['ComextechDiscount'] =  $total;
        }

        dd($quote);
       

    }
    
}
