<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{User,Application, ApplicationDetail, PaymentProvider, CategoryService, Service, Transport, Load};
use App\Models\{FileStore, FileStoreInternment, InternmentProcess, LocalWarehouse};

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
            
            if($request->application_id == 0)
            {
                \DB::table('application_sumamries')->insert([
                    [   
                        "application_id" => $application->id,
                        "category_service_id" => 1, 
                        "currency_id" => $application->currency_id ,
                        "description" => "A.- Pago proveedor",
                        "fee_date" => date('Y-m-d')
                    ],
                    [
                        "application_id" => $application->id,
                        "category_service_id" => 1, 
                        "currency_id" => $application->currency_id ,
                        "description" => "A.1.- Adelanto",
                        "fee_date" => date('Y-m-d')
                    ],
                    [ 
                        "application_id" => $application->id,
                        "category_service_id" => 1, 
                        "currency_id" => $application->currency_id ,
                        "description" => "A.2.- Saldo",
                        "fee_date" => date('Y-m-d')
                    ],
                    [
                        "application_id" => $application->id,
                        "category_service_id" => 3, 
                        "currency_id" => $application->currency_id ,
                        "description" => "B.- Transporte Internacional",
                        "fee_date" => date('Y-m-d')
                    ],
                    [
                        "application_id" => $application->id,
                        "category_service_id" => 3, 
                        "currency_id" => $application->currency_id ,
                        "description" => "C.- Seguro Transporte",
                        "fee_date" => date('Y-m-d')
                    ],
                    [
                        "application_id" => $application->id,
                        "category_service_id" => 4, 
                        "currency_id" => $application->currency_id ,
                        "description" => "D.- Servicio AGA",
                        "fee_date" => date('Y-m-d')
                    ],
                    [
                        "application_id" => $application->id,
                        "category_service_id" => 4, 
                        "currency_id" => $application->currency_id ,
                        "description" => "E.- IVA Internacion",
                        "fee_date" => date('Y-m-d')
                    ],
                    [
                        "application_id" => $application->id,
                        "category_service_id" => 4, 
                        "currency_id" => $application->currency_id ,
                        "description" => "F.- Aranceles",
                        "fee_date" => date('Y-m-d')
                    ],
                    [
                        "application_id" => $application->id,
                        "category_service_id" => 6, 
                        "currency_id" => $application->currency_id ,
                        "description" => "G.- Transporte Local",
                        "fee_date" => date('Y-m-d')
                    ],
                ]);
            }

            if($request->application_id > 0){

                \DB::table('application_sumamries')
                ->where("application_id", $application->id)
                ->update(['currency_id' => $application->currency_id]);
            }

            $cat_serv = CategoryService::whereIn('code', $request->services)
            ->select('id')
            ->pluck('id');
            
            $add_serv = Service::whereIn('category_service_id', $cat_serv)
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
        ->get()
        ->toJson();

        return response()->json($caterory, 200);
    }

    public function getApplication($id)
    {
        $data  = Application::where([
            ['id', '=', $id],
            ['user_id', auth()->user()->id],
        ])
        ->with('summary')
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
                        'estimated' =>  $request[$key]['datePay']
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
                         'type_pay'        => $data['typePay'],
                         'date_pay'        => $data['datePay'],
                         'payment_release' => $data['payment_release'],
                     ]
                 );

                 // update application summary
                 $description = $key == 0 ? 'A.1.- Adelanto' :'A.2.- Saldo';
                 $app_summ = \DB::table('application_sumamries')
                 ->where([
                    ["application_id", $application->id],
                    ["category_service_id", 1],
                    ["description", $description]
                    ])
                ->update(['fee_date' => $data['datePay'],
                         'amount'    =>  $application->amount * ($data['percentage'] / 100)
                        ]);
             }

             // update application summary main description
             $app_summ = \DB::table('application_sumamries')
             ->where([
                ["application_id", $application->id],
                ["category_service_id", 1],
                ["description", 'A.- Pago proveedor']
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

        $address_origin = $request->addressOrigin;
        $address_destination = $request->addressDestination;
        $origin_postal_code = 0;
        $destination_postal_code = 0;

        if(is_array($request->addressOrigin))
        {
            $address_origin = $request->addressOrigin['route'].', '.$request->addressOrigin['locality'].', '.$request->addressOrigin['country'];
            $origin_postal_code = isset($request->addressOrigin['postal_code']) ? $request->addressOrigin['postal_code'] : 0;
        }

        if(is_array($request->addressDestination))
        {
            $address_destination = $request->addressDestination['route'].', '.$request->addressDestination['locality'].', '.$request->addressDestination['country'];
            $destination_postal_code = isset($request->addressOrigin['postal_code']) ? $request->addressOrigin['postal_code'] : 0;
        }

        try {

            $transport =  Transport::updateOrCreate(
                ['application_id'   => $request->application_id, ],
                [
                    'fav_address_origin'    => $request->favoriteAddressOrigin,
                    'address_origin'        => $address_origin,
                    'origin_postal_code'    => $origin_postal_code,
                    'fav_dest_address'      => $request->favoriteAddressDestin,
                    'address_destination'   => $address_destination,
                    'destination_postal_code' => $destination_postal_code,
                    'estimated_date'        => $request->estimated_date,
                    'description'           => $request->description,
                    'insurance'             => $request->insurance,
                ]
            );

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
            //  dd($add_serv );
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
              $description = $key == 0 ? 'D.- Servicio AGA' :($key == 1 ? 'E.- IVA Internacion' : 'F.- Aranceles');
              $app_summ = \DB::table('application_sumamries')
              ->where([
                 ["application_id", $request->application_id],
                 ["category_service_id", 4],
                 ["description", $description]
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
                    'length_unit'    => $item['lengthUnit'],
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
