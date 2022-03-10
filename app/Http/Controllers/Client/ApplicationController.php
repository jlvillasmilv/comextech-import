<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\{User,Application, ApplicationDetail, PaymentProvider, CategoryService, Service, Transport, Load};
use App\Models\{Currency, FileStore, FedexApi, FileStoreInternment, InternmentProcess, LocalWarehouse, JumpSellerAppPayment};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Web\{ApplicationRequest, TransportRequest, InternmentProcessRequest, LocalWarehouseRequest};
use App\Notifications\AdminApplicationNotification;
use App\Notifications\Admin\ApplicationStatusNotification;
use Illuminate\Support\Facades\Crypt;

class ApplicationController extends Controller
{
    public function index()
    {
        $data  = Application::where('user_id', auth()->user()->id)
        ->orderBy('id','desc')
        ->get();

        return view('client.applications.index' , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.applications.form');
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
        //$services_code = array_diff($request->services, array("ICS07"));
        /** Evalua la el estado de una solicitud **/
        if ($status <> 0) { return response()->json($status, 400); }

        DB::beginTransaction();
    
         try {

            $value_initial = isset($request->valuePercentage['valueInitial']) ? $request->valuePercentage['valueInitial'] : 0;

            //  dd($request->value_initial <= 0 ? 0 : 100 - $value_initial);

            $application =  Application::updateOrCreate(
                ['id' => $request->application_id,
                'user_id'   => auth()->user()->id,
                ],
                [
                    'supplier_id'     => $request->statusSuppliers == 'with' ? $request->supplier_id : null,
                    'type_transport'  => $request->type_transport,
                    'amount'          => $request->amount,
                    'fee1'            => $value_initial,
                    'fee2'            => $request->value_initial <= 0 ? 0 : 100 - $value_initial,
                    'application_statuses_id' => 1,
                    'currency_id'   => is_null($request->currency_id) ? 1 : $request->currency_id,
                    'ecommerce_url' => $request->ecommerce_url,
                    'ecommerce_id'  => $request->statusSuppliers == 'E-commerce' ? $request->supplier_id : null,
                    'condition'     => $request->condition,
                    'services_code' => implode(',',$request->services),
                    'state_process' => true
                ]
            );

            $add_serv = Service::join('category_services as cs', 'services.category_service_id' , 'cs.id')
            ->whereIn('cs.code', $request->services)
            ->where('summary', false)
            ->select('services.id as service_id','cs.id as category_id');

            if($request->application_id > 0){

                \DB::table('application_summaries as as')
                ->join('services as s', 'as.service_id', '=', 's.id')
                ->where("as.application_id", $application->id)
                ->whereIn("s.code", ['CS01-01','CS01-02','CS01-03'])
                ->update(['as.currency_id' => $application->currency_id]);

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
                ->where('category_service_id', 1)
                ->update(['amount' => 0]);
            }

            if(Transport::where('application_id', $application->id)->exists() && !in_array('ICS03', $request->services) ){

                Transport::where('application_id', $application->id)->delete();

                \DB::table('application_summaries')
                ->where("application_id", $application->id)
                ->where('category_service_id', 3)
                ->update(['amount' => 0]);
            }

            if(InternmentProcess::where('application_id', $application->id)->exists() && !in_array('ICS04', $request->services) ){
                
                foreach ($application->internmentProcess->fileStoreInternment as $key => $item) {
              
                    $exists = \Storage::disk('s3')
                    ->exists('file/'.$item->fileStore->file_name);

                    // if($exists){
                    //     \Storage::disk('s3')
                    //     ->delete('file/'.$item->fileStore->file_name);
                    // }

                    FileStoreInternment::where('id', $item->id)->delete();

                    if (!is_null($item->fileStore->id)) {
                        FileStore::where('id', $item->fileStore->id)->delete();
                    }

                }

                InternmentProcess::where('application_id', $application->id)->delete();

                \DB::table('application_summaries')
                ->where("application_id", $application->id)
                ->where('category_service_id', 4)
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
                $add_summary = \DB::table('services')
                ->where('summary', true)
                ->select('id','name','category_service_id')
                ->orderby('name')
                ->get();

                foreach ($add_summary as $key => $item) {

                    \DB::table('application_summaries')->insert([
                        [   
                            "application_id"      => $application->id,
                            "category_service_id" => $item->category_service_id,
                            "service_id"          => $item->id, 
                            "currency_id"         => $application->currency_id,
                            "fee_date"            => date('Y-m-d'),
                            "currency2_id"        => 1
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

            if($request->type_transport == 'COURIER')
            {
                \DB::table('application_summaries as as')
                    ->join('services as s', 'as.service_id', '=', 's.id')
                    ->where([
                        ["as.application_id", $application->id],
                        ["as.status", true]
                    ])
                    ->whereIn("s.code", ['CS04-04','CS06-01','CS06-02'])
                    ->update(["as.status" => false, "as.amount" => 0]);

            }
            else {
                \DB::table('application_summaries as as')
                    ->join('services as s', 'as.service_id', '=', 's.id')
                    ->where([
                        ["as.application_id", $application->id],
                        ["as.status", false]
                    ])
                    ->whereIn("s.code", ['CS04-04','CS06-01','CS06-02'])
                    ->update(["as.status" => true]);
            }

            DB::commit();
        
            $appli = \DB::table('applications as app')
            ->leftjoin('user_mark_ups as ums', 'app.user_id', '=', 'ums.user_id')
            ->where('app.id', $application->id)
            ->select('app.id', 'app.code', 'app.supplier_id', 'app.currency_id','ums.transfer_abroad')
            ->first(); 
            
            
        } catch (Throwable $e)  {
            DB::rollback();
            return response()->json($e, 400);
        }

        return response()->json($appli, 200);
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
            ['id', '=',  Crypt::decryptString($id)],
            ['user_id', auth()->user()->id],
        ])
        ->with([
            'currency' => function($query) {
                $query->select('id', 'code', 'name');
            }, 
            'paymentProvider' => function($query) {
                $query->select('id', 'application_id', 'date_pay', 'payment_release', 'percentage', 'type_pay');
            },
            'summary' => function($query) {
                $query->where('status', true);
            }
            ,'transport','loads','internmentProcess','status'
        ])
        ->firstOrFail();

        return view('client.applications.show', compact('application'));
       
    }

    public function getApplicationSummary($id, $currency=null)
    {
        $summary = \DB::table('application_summaries as aps')
        ->join('currencies', 'aps.currency_id', '=', 'currencies.id')
        ->join('currencies as c2', 'aps.currency2_id', '=', 'c2.id')
        ->join('services as s', 'aps.service_id', 's.id')
        ->join('applications', 'aps.application_id', '=', 'applications.id')
        ->where([
            ["aps.application_id", $id],
            ["aps.status", true],
            ["applications.user_id", auth()->user()->id]
        ])
        ->select('aps.id','currencies.code as currency','s.code','s.name as description','aps.fee_date',
        'aps.amount', 'aps.amount2 as amo2', 'c2.code as currency2' )
        ->orderBy('s.id')
        ->get();

        return response()->json($summary, 200);
    }

    public function setApplicationSummary(Request $request)
    {
        $summary = \DB::table('application_summaries as aps')
        ->join('applications', 'aps.application_id', '=', 'applications.id')
        ->join('currencies as c1', 'aps.currency_id', '=', 'c1.id')
        ->join('currencies as c2', 'aps.currency2_id', '=', 'c2.id')
        ->where([
            ["aps.application_id", base64_decode($request->application_id)],
            ["aps.status", true],
            ["applications.user_id", auth()->user()->id]
        ])
        ->select(
            'aps.id',
            'aps.amount',
            'c1.code as currency',
            'aps.amount2',
            'aps.currency2_id',
            'c2.code as currency2',
        )
        ->get();

      //  dd($request->all());

        $total = 0;
        $currency = null;
        if(isset($request->currency_code) || !is_null($request->currency_code)){
            $currency = \DB::table('currencies')
            ->where("code", $request->currency_code)
            ->first();
        }

        foreach ($summary as $key => $item) {

                $to_currency_code = is_null($currency) ? $item->currency2 : $currency->code;
                $currency2_id     = is_null($currency) ? $item->currency2_id : $currency->id;

                $exchange = New Currency;
                $amount = $exchange->convertCurrency($item->amount, $item->currency, $to_currency_code);

                \DB::table('application_summaries')
                ->where('id', $item->id)
                ->update([
                    "amount2"      => $amount, 
                    "currency2_id" => $currency2_id
                ]);
  
        }

        $total = \DB::table('application_summaries')
                ->where("application_id", base64_decode($request->application_id))
                ->sum('amount2');

        $tco_clp = $total;

       // dd($item->currency.'  '.$to_currency_code.'  '.$tco_clp);

        if($to_currency_code != 'CLP'){
            $exchange = New Currency;
            $tco_clp = $exchange->convertCurrency($total, $item->currency, 'CLP');
        }

        $total_app = Application::where('id', base64_decode($request->application_id))
            ->update(["tco" => $total, "currency_tco" => $currency2_id, 'tco_clp' => $tco_clp]);

        return response()->json($total, 200);
       
    }

    public function edit($id)
    {   
        $id= Crypt::decryptString($id);
        return view('client.applications.edit', compact('id'));    
    }


    public function getApplication($id)
    {
        $data  = Application::where([
            ['id', $id],
            ['user_id', auth()->user()->id],
        ])
        ->select('id',
            'code',
            'supplier_id',
            'type_transport',
            'amount',
            'fee1',
            'fee2',
            'currency_id',
            'ecommerce_id',
            'ecommerce_url',
            'condition', 
            'services_code')
        ->with([
            'currency' => function($query) {
                $query->select('id', 'code', 'name');
            }, 
            'paymentProvider' => function($query) {
                $query->select('id', 'application_id', 'date_pay', 'payment_release', 'percentage', 'type_pay','transfer_abroad');
            }
            ,'transport','loads','internmentProcess','localWarehouse'
        ])
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
       
        PaymentProvider::where('application_id',  Crypt::decryptString($id))->delete();
        Transport::where('application_id',  Crypt::decryptString($id))->delete();

        if(Load::where('application_id',  Crypt::decryptString($id))->exists()){
            Load::where('application_id',  Crypt::decryptString($id))->delete();
        }

        Application::findOrFail( Crypt::decryptString($id))->delete();
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

            try {
                PaymentProvider::where('application_id', $application->id)->delete();

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
                            'transfer_abroad' => $data['transfer_abroad']
                        ]
                    );

                    // update application summary
                    $service_id = $key == 0 ? 'CS01-02' : 'CS01-03';
                    
                    \DB::table('application_summaries as as')
                        ->join('services as s', 'as.service_id', '=', 's.id')
                        ->where([
                            ["as.application_id", $application->id],
                            ["s.code",  $service_id]
                        ])
                    ->update(['as.fee_date' => $data['date_pay'],
                            'as.amount'    => $application->amount * ($data['percentage'] / 100)
                            ]);
                   
                }

                \DB::table('application_summaries as as')
                        ->join('services as s', 'as.service_id', '=', 's.id')
                        ->where([
                            ["as.application_id", $application->id],
                            ["s.code",  'CS01-04']
                        ])
                    ->update([
                            'as.fee_date'      => $data['date_pay'],
                            'as.amount'        => $values->sum('transfer_abroad'),
                            'as.currency_id'   => 8
                            ]);

            
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['status' => $e], 500);
            }
          
            return response()->json(['status' => 'OK'], 200);
        }

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
                [   'application_id'       => $request->application_id, ],
                [
                    'custom_agent_id'      => $request->custom_agent_id,
                    'customs_house'        => $request->customs_house,
                    'agent_payment'        => $request->agent_payment,
                    'trans_company_id'     => $request->trans_company_id,
                    'courier_svc'          => $request->courier_svc,
                    'iva'                  => $request->iva,
                    'iva_amt'              => $request->iva ? round($request->iva_amt, 0) : 0, 
                    'adv'                  => $request->adv,
                    'adv_amt'              => $request->adv ? round($request->adv_amt, 0) : 0,
                    'cif_amt'              => $request->cif_amt,
                    'insurance'            => $request->insurance,
                    'port_charges'         => $request->port_charges,
                    'transport_amt'        => $request->transport_amt,
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
              $service_id = $key == 0 ? 'CS04-01' :($key == 1 ? 'CS04-02' : 'CS04-03');

              \DB::table('application_summaries as as')
                    ->join('services as s', 'as.service_id', '=', 's.id')
                    ->where([
                        ["as.application_id", $request->application_id],
                        ["s.code",  $service_id]
                    ])
                ->update(['as.amount' =>  $mount,  'as.currency_id' =>  $key == 0 ? 8:1]);

             }

              // update AGA
              \DB::table('application_summaries as as')
                    ->join('services as s', 'as.service_id', '=', 's.id')
                    ->where([
                        ["as.application_id", $request->application_id],
                        ["s.code",  'CS04-04']
                    ])
                ->update(['as.amount' =>  $request->port_charges,  'as.currency_id' =>  8]);

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
            if($request->input('transport')=='true'){

                Load::cargo($request->input('dataLoad'),$request->application_id);
            }
        
            DB::commit();

        } catch (\Exception $e) {
             DB::rollback();
             return response()->json(['status' => $e], 500);
         }

        return response()->json(['loads' => $internment->application->loads], 200);
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

    public function dashboardMap()
    {
        $data  =  \DB::table('transports as trans')
        ->join('applications as app', 'trans.application_id', '=', 'app.id')
        ->where([
            ["app.user_id", auth()->user()->id],
            ["app.application_statuses_id", '<=', 3]
        ])
        ->select('app.code','app.type_transport',
        'trans.fav_origin_address','trans.origin_address','trans.origin_latitude','trans.origin_longitude',
        'trans.fav_dest_address','trans.dest_address','trans.dest_latitude','trans.dest_longitude')
        ->orderBy('app.id','desc')
        ->get();

        foreach ($data as $key => $value) {
            if ($value->fav_origin_address) {
                $origin = \DB::table('supplier_addresses')->where('id', $value->origin_address)->first(['latitude','longitude','address']);
                $value->origin_address   = $origin->address;
                $value->origin_latitude  = $origin->latitude;
                $value->origin_longitude = $origin->longitude;
            }

            if ($value->fav_dest_address) {
                $dest = \DB::table('company_addresses')->where('id', $value->dest_address)->first(['latitude','longitude','address']);
                $value->dest_address   = $dest->address;
                $value->dest_latitude  = $dest->latitude;
                $value->dest_longitude = $dest->longitude;
            }
        }

        return response()->json($data, 200);

    }

    

    public function updateStaus(Request $request)
    {
        $resp = Application::validateApplication(base64_decode($request->application_id));

        $application = Application::findOrFail(base64_decode($request->application_id));

        if(count($resp) > 0){

            $application->state_process =  false; 
            $application->save();  

            $string = implode("<br>", $resp);

            return response()->json(['notifications' => $string], 200);
        }

        $application->application_statuses_id =  $application->application_statuses_id + 1; 
        $application->save();

        /****Send notification to admin about change status applications**/
        $user_admin = User::whereHas('roles', function ($query) {
            $query->where('name','=', 'Admin');
        })->pluck('id');

        User::all()
            ->whereIn('id', $user_admin)
            ->each(function (User $user) use ($application) {
                $user->notify(new ApplicationStatusNotification($application));
        });

        return response()->json(['status' => 'OK'], 200);
    }


    public function notifications(Request $request)
    {
        $resp = Application::validateApplication(base64_decode($request->application_id));
        $notification = '';
        if(count($resp) > 0){
            foreach ($resp as $key => $value) {
                $notification = $notification.' <li>'.($key + 1).'.- '.$value.' </li>';
            }
            $notification =  '<ol> '.$notification.' </ol>';
        }

        return response()->json($notification, 200);
    }

}