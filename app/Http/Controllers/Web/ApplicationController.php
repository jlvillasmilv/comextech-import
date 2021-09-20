<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{User,Application, ApplicationDetail, PaymentProvider, CategoryService, Service, Transport, Load};
use App\Models\{Currency, FileStore, FileStoreInternment, InternmentProcess, LocalWarehouse};

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
                    'supplier_id'  => $request->statusSuppliers == 'with' ? $request->supplier_id : null,
                    'amount'       => $request->amount,
                    'fee1'         => $request->valuePercentage['valueInitial'],
                    'fee2'         => 100 - $request->valuePercentage['valueInitial'],
                    'application_statuses_id' => 1,
                    'currency_id'  => $request->currency_id,
                    'ecommerce_url' => $request->ecommerce_url,
                    'condition'    => $request->condition,
                ]
            );

            if($request->application_id > 0){

                \DB::table('application_sumamries')
                ->where("application_id", $application->id)
                ->whereNotIn('service_id', [23, 24])
                ->update(['currency_id' => $application->currency_id]);
            }

            if($request->application_id > 0){

                \DB::table('application_sumamries')
                ->where("application_id", $application->id)
                ->update(['currency_id' => $application->currency_id]);
            }

            $cat_serv = CategoryService::whereIn('code', $request->services)
            ->select('id')
            ->pluck('id');

            if($request->application_id == 0)
            {
                $add_sumamry = Service::where('sumamry', true)
                ->select('id','name','category_service_id')
                ->orderby('name')
                ->get();

                foreach ($add_sumamry as $key => $item) {

                    \DB::table('application_sumamries')->insert([
                        [   
                            "application_id"      => $application->id,
                            "category_service_id" => $item->category_service_id,
                            "service_id"  => $item->id, 
                            "currency_id" => $application->currency_id ,
                            "description" => $item->name,
                            "fee_date" => date('Y-m-d')
                        ]
                    ]);
                }
            }
            
            $add_serv = Service::whereIn('category_service_id', $cat_serv)
            ->where('sumamry', false)
            ->select('id')
            ->pluck('id');

            \DB::table('application_details')
                ->whereNotIn('service_id', $add_serv)
                ->where('application_id', $application->id)
                ->delete();
               
            foreach ($add_serv as $key => $id) {

                ApplicationDetail::updateOrCreate(
                    ['application_id' => $application->id,
                     'service_id'   => $id,
                    ],
                    [
                       'currency_id'  => $application->currency_id,
                       'currency2_id' => $application->currency_id,
                    ]
                );
            }

            DB::commit();

             /*******case exist services previous associate********/

            if(Transport::where('application_id', $application->id)->exists() && !in_array('ICS03', $request->services) ){
                Transport::where('application_id', $application->id)->delete();
            }

            if(InternmentProcess::where('application_id', $application->id)->exists() && !in_array('ICS04', $request->services) ){
                InternmentProcess::where('application_id', $application->id)->delete();
            }

            if(PaymentProvider::where('application_id', $application->id)->exists() && !in_array('ICS01', $request->services) ){
                PaymentProvider::where('application_id', $application->id)->delete();
            }

            if(Load::where('application_id', $application->id)->exists() && !in_array(['ICS01','ICS03','ICS04'], $request->services) ){
                Load::where('application_id', $application->id)->delete();
            }

            if(LocalWarehouse::where('application_id', $application->id)->exists() && !in_array('ICS05', $request->services) ){
                LocalWarehouse::where('application_id', $application->id)->delete();
            }


            /****Enviar notificaiones a los adminstradores sobre la nueva solicitud**/
            $user_admin = User::whereHas('roles', function ($query) {
                $query->where('name','=', 'Admin');
            })->pluck('id');

            User::all()
                ->whereIn('id', $user_admin)
                ->each(function (User $user) use ($application) {
                    $user->notify(new AdminApplicationNotification($application));
                });

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

        //dd($data);
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
        ->with('summary','currency','paymentProvider','transport','loads')
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
                 $app_summ = \DB::table('application_sumamries')
                 ->where([
                    ["application_id", $application->id],
                    ["category_service_id", 1],
                    ["service_id", $service_id]
                    ])
                ->update(['fee_date' => $data['date_pay'],
                         'amount'    =>  $application->amount * ($data['percentage'] / 100)
                        ]);
             }

             // update application summary main description
             $app_summ = \DB::table('application_sumamries')
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
    public function transports(Request $request)
    {
        DB::beginTransaction();

        try {

            $transport =  Transport::updateOrCreate(
                ['application_id'   => $request->application_id, ],
                [
                    'fav_address_origin'    => $request->fav_address_origin,
                    'address_origin'        => $request->address_origin,
                    'origin_latitude'       => $request->origin_latitude,
                    'origin_longitude'      => $request->origin_longitude,
                    'origin_postal_code'    => $request->origin_postal_code,
                    'fav_dest_address'      => $request->fav_dest_address,
                    'address_destination'   => $request->address_destination,
                    'dest_latitude'         => $request->dest_latitude,
                    'dest_longitude'        => $request->dest_longitude,
                    'dest_postal_code'      => $request->dest_postal_code,
                    'estimated_date'        => $request->estimated_date,
                    'description'           => $request->description,
                    'insurance'             => $request->insurance,
                ]
            );

            $exchange = New Currency;
            $app_amount = $exchange->convertCurrency($transport->application->amount, $transport->application->currency->code, 'USD');

            $add_serv = Service::join('category_services as cs', 'services.category_service_id' , 'cs.id')
            ->where('cs.code', $request->code_serv)
            ->select('services.id')
            ->pluck('services.id');
 
            foreach ($add_serv as $key => $id) {

                $mount = $key == 0 ? $app_amount * 0.15 : $app_amount * 0.5 ;

                ApplicationDetail::updateOrCreate([
                     'application_id' =>  $request->application_id,
                     'service_id' => $id
                     ],                    
                     [
                        'amount' =>  $mount,
                        'currency_id' =>  8
                     ],
                 );

             // update application summary main description
              $service_id = $key == 0 ? 23 : 24;
              $app_summ = \DB::table('application_sumamries')
              ->where([
                 ["application_id", $request->application_id],
                 ["category_service_id", 3],
                 ["service_id", $service_id]
                 ])
             ->update(['amount' =>  $mount,  'currency_id' =>  8]);
 
             }

            $this->load($request->input('dataLoad'),$request->application_id);

         DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'Error'], 400);
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
                    'custom_agent_id'       => $request->custom_agent_id,
                    'customs_house'         => $request->customs_house,
                    'agent_payment'         => $request->agent_payment,
                    'iva'                   => $request->iva,
                     'iva_amt'              => $request->iva ? round($request->iva_amt, 0) : 0, 
                     'adv'                  => $request->adv,
                     'adv_amt'              => $request->adv ? round($request->adv_amt, 0) : 0,
                     'cif_amt'              => round($request->cif_amt, 0),
                ]
            );

            $add_serv = Service::join('category_services as cs', 'services.category_service_id' , 'cs.id')
            ->where('cs.code', $request->code_serv)
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

             // update application summary main description
              $service_id = $key == 0 ? 25 :($key == 1 ? 26 : 27);
              $app_summ = \DB::table('application_sumamries')
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
            if(!$request->input('transport')){
               
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
                    'high'           => $item['high'],
                    'mode_calculate' => $item['mode_calculate'],
                    'mode_selected'  => $item['mode_selected'],
                    'type_container' => $item['type_container'],
                    'type_load'      => $item['type_load'],
                    'weight'         => $item['weight'],
                    'weight_units'   => $item['weight_units'],
                ]
            );
          }

        return true;
    }



}
