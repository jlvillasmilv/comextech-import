<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{User,Application, ApplicationDetail, PaymentProvider, Service, Transport, Load};
use App\Models\{FileStore, FileStoreInternment, InternmentProcess, LocalWarehouse};

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\Web\{ApplicationRequest, TransportRequest, InternmentProcessRequest, LocalWarehouseRequest};
use App\Http\Requests\Web\{LoadRequest};
use App\Notifications\AdminApplicationNotification;

class ApplicationController extends Controller
{
    public function index()
    {

        $data  = Application::where('user_id', auth()->user()->id)->paginate();

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        $app_id = new Application;
        $status = $app_id->validStatus($request->application_id);

        if ($status <> 0) { return response()->json($status, 400); }

        DB::beginTransaction();

        try {
            $data =  Application::updateOrCreate(
                ['id' => $request->application_id,
                'user_id'   => auth()->user()->id,
                ],
                [
                    'supplier_id'  => $request->statusSuppliers == 'with' ? $request->supplier_id : null,
                    'amount'       => $request->amount,
                    'application_statuses_id' => 1,
                    'currency_id' => $request->currency_id,
                    'description' => $request->description,
                    'condition'   => $request->condition,
                ]
            );

            $category_id = array();

            foreach ($request->services as $key => $service) {
                $category_id[] =  $service["id"];
            }

            $add_serv = Service::whereIn('category_service_id', $category_id)
            ->select('id')
            ->pluck('id');

             \DB::table('application_details')
                ->whereNotIn('service_id', $add_serv)
                ->where('application_id', $data->id)
                ->delete();

            foreach ($add_serv as $key => $id) {

                ApplicationDetail::updateOrCreate(
                    ['application_id' => $data->id,
                     'service_id'   => $id,
                    ],
                    [
                       'currency_id'  => $data->currency_id,
                       'currency2_id' => $data->currency_id,
                    ]
                );
            }

            DB::commit();

            $user_admin = User::whereHas('roles', function ($query) {
                $query->where('name','=', 'Admin');
            })->pluck('id');

            User::all()
                ->whereIn('id', $user_admin)
                ->each(function (User $user) use ($data) {
                    $user->notify(new AdminApplicationNotification($data));
                });

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(0, 400);
        }

         return response()->json($data->id, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {

        $data  = Application::where([
            ['id', '=', $id],
            ['user_id', auth()->user()->id],
        ])->firstOrFail();

        return response()->json($data, 200);

    }


    public function edit($id)
    {
        $data  = Application::where([
            ['id', '=', $id],
            ['user_id', auth()->user()->id],
        ])->firstOrFail();

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


    public function paymentProvider(Request $request)
    {
        // dd($request->all());
        $values = collect($request);

        if ($values->sum('percentage') > 100){
            return response()->json(['error' => ['PORCENTAJE No debe ser mayor a 100 %']], 401);
        }

        if ($values->sum('percentage') == 100){

            PaymentProvider::where('application_id', $request[0]['application_id'])->delete();

            foreach ($request->input() as $key => $data) {

                 PaymentProvider::updateOrCreate(
                     [
                         'application_id'  => $data['application_id'],
                         'percentage'      => $data['percentage'],
                         'type_pay'        => $data['typePay'],
                 ],
                     [
                         'date_pay'        => $data['datePay'],
                         'payment_release' => $data['payment_release'],
                     ]
                 );
             }

             return response()->json(['status' => 'OK'], 200);
        }


    }

    public function transports(TransportRequest $request)
    {
        DB::beginTransaction();

        try {

            $transport =  Transport::updateOrCreate(
                ['application_id'   => $request->application_id, ],
                [
                    'address_destination'   => $request->addressDestination,
                    'address_origin'        => $request->addressOrigin,
                    'destinacion'           => $request->destinacion,
                    'destinacion_warehouse' => $request->destinacionWarehouse,
                    'origin'                => $request->origin,
                    'origin_warehouse'      => $request->originWarehouse,
                    'estimated_date'        => $request->estimated_date,
                    'description'           => $request->description,
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

    public function internmentProcesses(InternmentProcessRequest $request)
    {
        //   dd($request->all());
        DB::beginTransaction();

        try {

            $internment = InternmentProcess::updateOrCreate(
                ['application_id'   => $request->application_id, ],
                [
                    'custom_agent_id'       => $request->custom_agent_id,
                    'customs_house'         => $request->customs_house,
                    'agent_payment'         => $request->agent_payment,
                    // 'certificate'           => $request->certificate,
                ]
            );

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
                'trans_company_id'  => $request->trans_company_id,
                'warehouse_id'      => $request->warehouse_id,
            ]
        );

        return response()->json($localw->id, 200);
    }


    public function load($data=null,$application_id=null)
    {
       
        // $this->validate($data, [
        //     'dataLoad.*.mode_selected'   => 'required|string',
        //     "dataLoad.*.length"          => "required_if:dataLoad.*.mode_selected,in:AEREO,CONSOLIDADO",
        //     "dataLoad.*.width"           => "required_if:dataLoad.*.mode_selected,in:AEREO,CONSOLIDADO",
        //     "dataLoad.*.high"            => "required_if:dataLoad.*.mode_selected,in:AEREO,CONSOLIDADO",
        //     "dataLoad.*.weight"          => "required|numeric",
        //     "dataLoad.*.type_load"       => 'required_if:dataLoad.*.mode_selected,in:AEREO,CONSOLIDADO',
        //     "dataLoad.*.type_container"  => 'required_if:dataLoad.*.mode_selected,in:CONTAINER',
        // ]);

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
