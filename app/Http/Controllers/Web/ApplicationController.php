<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{User,Application, ApplicationDetail, PaymentProvider, CategoryService, Service, Transport, Load};
use App\Models\{Currency, FileStore, FedexApi, FileStoreInternment, InternmentProcess, LocalWarehouse};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Web\{ApplicationRequest, TransportRequest, InternmentProcessRequest, LocalWarehouseRequest};
use App\Notifications\AdminApplicationNotification;
use Illuminate\Support\Facades\Crypt;

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
        //$services_code = array_diff($request->services, array("ICS07"));
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
                    'type_transport'  => $request->type_transport,
                    'amount'          => $request->amount,
                    'fee1'            => $request->statusSuppliers == 'with' ? $request->valuePercentage['valueInitial'] : 0,
                    'fee2'            => $request->statusSuppliers == 'with' ? 100 - $request->valuePercentage['valueInitial'] : 0,
                    'application_statuses_id' => 1,
                    'currency_id'   => $request->currency_id,
                    'ecommerce_url' => $request->ecommerce_url,
                    'ecommerce_id'  => $request->statusSuppliers == 'E-commerce' ? $request->supplier_id : null,
                    'condition'     => $request->condition,
                    'services_code' => implode(',',$request->services)
                ]
            );

            $add_serv = Service::join('category_services as cs', 'services.category_service_id' , 'cs.id')
            ->whereIn('cs.code', $request->services)
            ->where('summary', false)
            ->select('services.id as service_id','cs.id as category_id');

            if($request->application_id > 0){

                \DB::table('application_summaries')
                ->where("application_id", $application->id)
                ->whereIn('service_id', [19, 20,21])
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
                            "fee_date"    => date('Y-m-d')
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
            
            $appli = Application::where('id', $application->id)
            ->select('id', 'code', 'supplier_id', 'currency_id')
            ->firstOrFail();  

        } catch (\Exception $e) {
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
        ])->firstOrFail();

        return view('applications.show', compact('application'));
       
    }

    public function edit($id)
    {   
        $id= Crypt::decryptString($id);
        return view('services.edit', compact('id'));    
    }

    public function getApplicationCategory($id)
    {
        $caterory = \DB::table('application_details')
        ->where('application_id',$id)
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
            ['id', $id],
            ['user_id', auth()->user()->id],
        ])
        ->select('id',
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
                $query->select('id', 'application_id', 'date_pay', 'payment_release', 'percentage', 'type_pay');
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
                 $service_id = $key == 0 ? 'CS01-02' : 'CS01-03';
                 // update application summary local transport
                 
                \DB::table('application_summaries as as')
                    ->join('services as s', 'as.service_id', '=', 's.id')
                    ->where([
                        ["as.application_id", $application->id],
                        ["s.code",  $service_id]
                    ])
                ->update(['as.fee_date' => $data['date_pay'],
                         'as.amount'    =>  $application->amount * ($data['percentage'] / 100)
                        ]);
             }

             // update application summary
           \DB::table('application_summaries as as')
                ->join('services as s', 'as.service_id', '=', 's.id')
                ->where([
                    ["as.application_id", $application->id],
                    ["s.code", 'CS01-01']
                ])
            ->update(['as.amount' =>  $application->amount]);

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
            //dd($request->all());
            $internment = InternmentProcess::updateOrCreate(
                [   'application_id'   => $request->application_id, ],
                [
                    'custom_agent_id'      => $request->custom_agent_id,
                    'customs_house'        => $request->customs_house,
                    'agent_payment'        => $request->agent_payment,
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
            if($request->input('transport')){
               
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
            ["app.user_id", auth()->user()->id]
        ])
        ->select('app.code','app.type_transport',
        'trans.fav_origin_address','trans.origin_address','trans.origin_latitude','trans.origin_longitude',
        'trans.fav_dest_address','trans.dest_address','trans.dest_latitude','trans.dest_longitude')
        ->orderBy('app.id','desc')
        ->get();

        foreach($data as $key => $value) {
            if ($value->fav_origin_address) {
                $origin = \DB::table('supplier_addresses')->where('id', $value->origin_address)->first(['latitude','longitude']);
                $value->origin_latitude  = $origin->latitude;
                $value->origin_longitude = $origin->longitude;
            }

            if ($value->fav_dest_address) {

                $dest = \DB::table('company_addresses')->where('id', $value->dest_address)->first(['latitude','longitude']);
                $value->dest_latitude  = $dest->latitude;
                $value->dest_longitude = $dest->longitude;
            }
           
        }

        //dd($data);

        return response()->json($data, 200);

    }


}