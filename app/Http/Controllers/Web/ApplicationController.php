<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{User,Application, ApplicationDetail, PaymentProvider, CategoryService, Service, Transport, Load};
use App\Models\{Currency, FileStore, FedexApi, FileStoreInternment, InternmentProcess, LocalWarehouse};
use App\Models\services\DHL;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Web\{ApplicationRequest, TransportRequest, InternmentProcessRequest, LocalWarehouseRequest};
use App\Notifications\AdminApplicationNotification;

class ApplicationController extends Controller
{
    public function index()
    {
        $data  = Application::where('user_id', auth()->user()->id)
        ->orderBy('id','desc')
        ->paginate(7);

        return view('applications.index' , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('applications.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * Generate a new Application
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * validaciion de campos antes de generar solicitud
     */
    public function store(ApplicationRequest $request)
    {
        $app_id = new Application;
        $status = $app_id->validStatus($request->application_id);
        /** Evalua la el estado de una solicitud **/
        if ($status <> 0) { return response()->json($status, 400); }

        DB::beginTransaction();
        
        try {

            $application =  Application::updateOrCreate(
                ['id' => $request->application_id,
                'user_id'   => auth()->user()->id,
                ],
                [
                    'supplier_id'     => $request->statusSuppliers == 'with' ? $request->supplier_id : null,
                    'type_transport'  => $item['type_transport'],
                    'amount'          => $request->amount,
                    'fee1'         => $request->statusSuppliers == 'with' ? $request->valuePercentage['valueInitial'] : 0,
                    'fee2'         => $request->statusSuppliers == 'with' ? 100 - $request->valuePercentage['valueInitial'] : 0,
                    'application_statuses_id' => 1,
                    'currency_id'   => $request->currency_id,
                    'ecommerce_url' => $request->ecommerce_url,
                    'ecommerce_id'  => $request->statusSuppliers == 'E-commerce' ? $request->supplier_id : null,
                    'condition'     => $request->condition,
                ]
            );

            $add_serv = Service::join('category_services as cs', 'services.category_service_id' , 'cs.id')
            ->whereIn('cs.code', $request->services)
            ->where('summary', false)
            ->select('services.id as service_id','cs.id as category_id');

            if($request->application_id > 0){

                \DB::table('application_summaries')
                ->where("application_id", $application->id)
                ->whereIn('service_id', [20, 21,22])
                ->update(['currency_id' => $application->currency_id]);

                \DB::table('application_details')
                ->whereNotIn('service_id', $add_serv->pluck('services.id as service_id'))
                ->where('application_id', $application->id)
                ->delete();
            }


            foreach ($add_serv->get() as $key => $item) {
                
                ApplicationDetail::updateOrCreate(
                    ['application_id' => $application->id,
                     'service_id'     => $item->service_id,
                    ],
                    [
                       'category_service_id' => $item->category_id,
                       'currency_id'  => $application->currency_id,
                       'currency2_id' => $application->currency_id,
                    ]
                );
            }

            /*******case exist services previous associate delete and amoutn summary 0********/

            if(PaymentProvider::where('application_id', $application->id)->exists() && !in_array('ICS01', $request->services) ){

                PaymentProvider::where('application_id', $application->id)->delete();

                \DB::table('application_summaries')
                ->where("application_id", $application->id)
                ->whereIn('service_id', [20, 21,22])
                ->update(['amount' => 0]);
            }

            if(Transport::where('application_id', $application->id)->exists() && !in_array('ICS03', $request->services) ){

                Transport::where('application_id', $application->id)->delete();

                \DB::table('application_summaries')
                ->where("application_id", $application->id)
                ->whereIn('service_id', [23, 24])
                ->update(['amount' => 0]);
            }

            if(InternmentProcess::where('application_id', $application->id)->exists() && !in_array('ICS04', $request->services) ){
                
                InternmentProcess::where('application_id', $application->id)->delete();

                \DB::table('application_summaries')
                ->where("application_id", $application->id)
                ->whereIn('service_id', [25, 26,27])
                ->update(['amount' => 0]);
            }

            if(Load::where('application_id', $application->id)->exists() && !in_array('ICS03', $request->services)){
                //'ICS01','ICS03','ICS04'
                if(Load::where('application_id', $application->id)->exists() && in_array('ICS04', $request->services)){

                }
                else{
                    Load::where('application_id', $application->id)->delete();
                }

            }

            if(LocalWarehouse::where('application_id', $application->id)->exists() && !in_array('ICS05', $request->services) ){
                LocalWarehouse::where('application_id', $application->id)->delete();
            }

            if($request->application_id == 0)
            {
                $add_summary = Service::where('summary', true)
                ->select('id','name','category_service_id')
                ->orderby('name')
                ->get();

                foreach ($add_summary as $key => $item) {

                    \DB::table('application_summaries')->insert([
                        [   
                            "application_id"      => $application->id,
                            "category_service_id" => $item->category_service_id,
                            "service_id"  => $item->id, 
                            "currency_id" => $application->currency_id,
                            "fee_date" => date('Y-m-d')
                        ]
                    ]);
                }

                /****Send notification to admin about new applications**/
                $user_admin = User::whereHas('roles', function ($query) {
                    $query->where('name','=', 'Admin');
                })->pluck('id');
    
                User::all()
                    ->whereIn('id', $user_admin)
                    ->each(function (User $user) use ($application) {
                        $user->notify(new AdminApplicationNotification($application));
                });
            }

            DB::commit();          

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e, 400);
        }

        return response()->json($application, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application  = Application::where([
            ['id', '=', base64_decode($id)],
            ['user_id', auth()->user()->id],
        ])->firstOrFail();

        return view('applications.show', compact('application'));
       
    }

    public function edit($id)
    {
        return view('services.edit', compact('id'));    
    }

    public function getApplicationCategory($id)
    {
        $caterory = ApplicationDetail::where('application_id',$id)
        ->join('services as s', 'application_details.service_id', 's.id')
        ->join('category_services as cs', 's.category_service_id', 'cs.id')
        ->groupBy('cs.code')
        ->select('cs.code')
        ->pluck('cs.code');

        return response()->json($caterory, 200);
    }

    public function getApplication($id)
    {
        $data  = Application::where([
            ['id', '=', $id],
            ['user_id', auth()->user()->id],
        ])
        ->with('currency','paymentProvider','transport','loads','internmentProcess','localWarehouse')
        ->firstOrFail();
        
        return response()->json($data, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRequest $request, $id)
    {
        $app_id = new Application;
        $status = $app_id->validStatus($id);

        if ($status <> 0) { return response()->json($status, 400); }

        $data = Application::findOrFail($id);

        $data->fill($request->all())->save();

        return response()->json(['status' => 'OK'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Application::findOrFail($id)->delete();
        return response()->json(['status' => 'OK'], 200);
    }


     /**
     * @author Jorge Villasmil.
     *
     * Generate a new or update Payment Provider in storage.
     * 
     * @param  \Illuminate\Http\Request  $request Array
     * @return \Illuminate\Http\Response
     * 
     */
    public function paymentProvider(Request $request)
    {
        $values = collect($request);

        if ($values->sum('percentage') > 100 || $values->sum('percentage') < 100) {
            return response()->json(['error' => ['PORCENTAJE No debe ser mayor a 100 %']], 422);
        }

        $application = Application::findOrFail($request[0]['application_id']); 

        if ($values->sum('percentage') == 100){
          
            PaymentProvider::where('application_id', $application->id)->delete();

            $cat_serv = CategoryService::where('code',  $request[0]['code_serv'])
                 ->select('id')
                 ->pluck('id');


            $add_serv = Service::where('category_service_id', $cat_serv)
                 ->where('summary', false)
                 ->select('id')
                 ->pluck('id');
                
            foreach ($add_serv as $key => $id) {
                
               if (isset($request[$key]['application_id']))
                    ApplicationDetail::updateOrCreate([
                    'application_id' =>  $application->id,
                    'service_id' => $id
                    ],                    
                    [
                        'amount' =>  $application->amount * ($request[$key]['percentage'] / 100),
                        'estimated' =>  $request[$key]['date_pay']
                    ],
                );

            }

            foreach ($request->input() as $key => $data) {

                 PaymentProvider::updateOrCreate(
                     [
                         'application_id'  => $application->id,
                         'percentage'      => $data['percentage'],
                     ],
                     [
                         'type_pay'        => $data['type_pay'],
                         'date_pay'        => $data['date_pay'],
                         'payment_release' => $data['payment_release'],
                     ]
                 );

                 // update application summary
                 $service_id = $key == 0 ? 21 : 22;
                 $app_summ = \DB::table('application_summaries')
                 ->where([
                    ["application_id", $application->id],
                    ["category_service_id", 1],
                    ["service_id", $service_id]
                    ])
                ->update(['fee_date' => $data['date_pay'],
                         'amount'    =>  $application->amount * ($data['percentage'] / 100)
                        ]);
             }

             // update application summary
             $app_summ = \DB::table('application_summaries')
             ->where([
                ["application_id", $application->id],
                ["category_service_id", 1],
                ["service_id", 20]
                ])
            ->update(['amount' =>  $application->amount]);

             return response()->json(['status' => 'OK'], 200);
        }

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
    public function transports(TransportRequest $request)
    {
        DB::beginTransaction();

         try {
                      
            $transport =  Transport::updateOrCreate(
                ['application_id'   => $request->application_id, ],
                [
                    'trans_company_id'      => $request->trans_company_id,
                    'fav_address_origin'    => $request->fav_address_origin,
                    'address_origin'        => $request->address_origin,
                    'origin_latitude'       => $request->origin_latitude,
                    'origin_longitude'      => $request->origin_longitude,
                    'origin_postal_code'    => $request->origin_postal_code,
                    'origin_ctry_code'      => $request->origin_ctry_code,
                    'fav_dest_address'      => $request->fav_dest_address,
                    'address_destination'   => $request->address_destination,
                    'dest_latitude'         => $request->dest_latitude,
                    'dest_longitude'        => $request->dest_longitude,
                    'dest_postal_code'      => $request->dest_postal_code,
                    'dest_ctry_code'        => $request->dest_ctry_code,
                    'estimated_date'        => $request->estimated_date,
                    'description'           => $request->description,
                    'insurance'             => $request->insurance,
                ]
            );

            $this->load($request->input('dataLoad'),$request->application_id);

            $app_amount = !is_null($request->app_amount) ? $request->app_amount : 0;

            //$exchange = New Currency;
            //$app_amount = $exchange->convertCurrency($transport->application->amount, $transport->application->currency->code, 'USD');

            $add_serv = Service::join('category_services as cs', 'services.category_service_id' , 'cs.id')
            ->where('cs.code', $request->code_serv)
            ->where('services.summary', false)
            ->select('services.id')
            ->pluck('services.id');

            foreach ($add_serv as $key => $id) {

                $mount = $key == 0 ? $app_amount : $app_amount * 0.5 ;

                ApplicationDetail::updateOrCreate([
                     'application_id' =>  $request->application_id,
                     'service_id' => $id
                     ],
                     [
                        'amount' =>  $mount,
                        'currency_id' =>  8
                     ],
                 );

             // update application summary
              $service_id = $key == 0 ? 23 : 24;
              $app_summ = \DB::table('application_summaries')
              ->where([
                 ["application_id", $request->application_id],
                 ["category_service_id", 3],
                 ["service_id", $service_id]
                 ])
             ->update(['amount' =>  $mount,  'currency_id' =>  8, 'fee_date' => $request->estimated_date]);

            }

         DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => $e], 400);
        }

        return response()->json($transport->id, 200);
    }


    /**
     * @author Jorge Villasmil.
     *
     * Generate a new or Update internment processes data in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
    */
    public function internmentProcesses(InternmentProcessRequest $request)
    {
        DB::beginTransaction();

        try {

            $internment = InternmentProcess::updateOrCreate(
                ['application_id'   => $request->application_id, ],
                [
                    'custom_agent_id'      => $request->custom_agent_id,
                    'customs_house'        => $request->customs_house,
                    'agent_payment'        => $request->agent_payment,
                    'iva'                  => $request->iva,
                    'iva_amt'              => $request->iva ? round($request->iva_amt, 0) : 0, 
                    'adv'                  => $request->adv,
                    'adv_amt'              => $request->adv ? round($request->adv_amt, 0) : 0,
                    'cif_amt'              => round($request->cif_amt, 0),
                ]
            );

            $add_serv = Service::join('category_services as cs', 'services.category_service_id' , 'cs.id')
            ->where('cs.code', $request->code_serv)
            ->where('services.summary', false)
            ->select('services.id')
            ->pluck('services.id');
 
            foreach ($add_serv as $key => $id) {

                $mount = $key == 0 ? $request->agent_payment : 0 ;
                $mount = ($key == 1 && $request->iva ) ? round($request->iva_amt, 0) : $mount ;
                $mount = ($key > 1 && $request->adv ) ? round($request->adv_amt, 0) : $mount ;
                
                     ApplicationDetail::updateOrCreate([
                     'application_id' =>  $request->application_id,
                     'service_id' => $id
                     ],                    
                     [
                        'amount' =>  $mount,
                        'currency_id' =>  1
                     ],
                 );

             // update application summary
              $service_id = $key == 0 ? 25 :($key == 1 ? 26 : 27);
              $app_summ = \DB::table('application_summaries')
              ->where([
                 ["application_id", $request->application_id],
                 ["category_service_id", 4],
                 ["service_id", $service_id]
                 ])
             ->update(['amount' =>  $mount,  'currency_id' =>  1]);
 
             }

            // agregar datos de subida de archivo
            if ($request->hasFile('files')) {
                foreach ($request->input('file_descrip') as $key => $file) {
                    $data = new FileStore;
                    $file_storage = $data->addFile(
                        $request->file('files')[$key],
                        $file.'-'.$request->application_id.'-'.$internment->id);

                    FileStoreInternment::updateOrCreate(
                        ['file_store_id' => $file_storage->id,
                         'internment_id' => $internment->id,
                        ],
                        [ 'intl_treaty' => $file, ]
                    );

                }
            }

            if ($request->hasFile('file_certificate')) {

                    $data = new FileStore;
                    $file_storage = $data->addFile(
                        $request->file('file_certificate'),
                        $request->certificate.'-'.$request->application_id.'-'.$internment->id);

                    FileStoreInternment::updateOrCreate(
                        ['file_store_id' => $file_storage->id,
                         'internment_id' => $internment->id,
                        ],
                        [ 'intl_treaty' => $request->certificate, ]
                    );

            }

            //Agrega datos a carga de transporte
            if($request->input('transport')){
               
                $this->load($request->input('dataLoad'),$request->application_id);
            }
        
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => $e], 400);
        }

        return response()->json($internment->id, 200);
    }

    public function localWarehouse(LocalWarehouseRequest $request)
    {
        $localw =  LocalWarehouse::updateOrCreate(
            ['application_id'   => $request->application_id, ],
            [
                'peoneta_service'  => $request->peoneta_service,
                'forklift_service'  => $request->forklift_service,
                'warehouse_id'      => $request->warehouse_id,
            ]
        );

        return response()->json($localw->id, 200);
    }


    /**
     * Store or update a resource in storage.
     * 
     */
    public function load($data,$application_id=null)
    {
        Load::where('application_id', $application_id)->delete();
        foreach ($data as $key => $item) {

            Load::updateOrCreate(
                ['application_id'   => $application_id,
                 'cbm'            => $item['cbm'],
                 'stackable'      => $item['stackable'],
                ],

                [
                    'length_unit'    => $item['length_unit'],
                    'length'         => $item['length'],
                    'width'          => $item['width'],
                    'height'         => $item['height'],
                    'mode_calculate' => $item['mode_calculate'],
                    'type_container' => $item['type_container'],
                    'type_load'      => $item['type_load'],
                    'weight'         => $item['weight'],
                    'weight_units'   => $item['weight_units'],
                ]
            );
          }

        return true;
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

            if($request->input('dataLoad')[0]['type_transport'] == 'COURIER' || $request->input('dataLoad')[0]['type_transport'] == 'CARGA AEREA' || $request->input('dataLoad')[0]['type_transport'] == 'CONSOLIDADO')
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

         } catch (\Exception $e) {
             return response()->json(['status' => $e], 400);
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
            if($request->input('dataLoad')[0]['type_transport'] == 'COURIER' || $request->input('dataLoad')[0]['type_transport'] == 'CARGA AEREA' || $request->input('dataLoad')[0]['type_transport'] == 'CONSOLIDADO')
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
            return response()->json(['status' => $e], 400);
        }
    }

    public function test()
    {
        $data = [
            "fav_address_origin" => true,
            "address_origin" => "1",
            "origin_latitude" => null,
            "origin_longitude" => null,
            "origin_postal_code" => null,
            "origin_locality" => null,
            "origin_ctry_code" => null,
            "fav_dest_address" => true,
            "address_destination" => "1",
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

        //dd($arrOutput);

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