<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{User,Application, ApplicationDetail, PaymentProvider, Service, Transport, Load};
use App\Models\{FileStore, InternmentProcess, InternmentLoad};

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\Web\{ApplicationRequest, TransportRequest};
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
        DB::beginTransaction();

        try {
            $data =  Application::updateOrCreate(
                ['id' => $request->application_id,
                'user_id'   => auth()->user()->id,
                ],
                [
                    'supplier_id'  => $request->supplier_id,
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
            return response()->json(['status' => 'Error'], 400);
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

         foreach ($request->input('dataLoad') as $key => $data) {

            Load::updateOrCreate(
                ['transport_id' => $transport->id],
                [
                    'cbm'            => $data['cbm'],
                    'length_unit'    => $data['lengthUnit'],
                    'length'         => $data['length'],
                    'width'          => $data['width'],
                    'high'           => $data['high'],
                    'mode_calculate' => $data['mode_calculate'],
                    'mode_selected'  => $data['mode_selected'],
                    'type_container' => $data['type_container'],
                    'type_load'      => $data['type_load'],
                    'weight'         => $data['weight'],
                    'weight_units'   => $data['weight_units'],
                    'stackable'      => $data['stackable'],
                ]
            );
          }

         DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'Error'], 400);
        }

        return response()->json($transport->id, 200);
    }

    public function internmentProcesses(Request $request)
    {

        DB::beginTransaction();

        try {

            $internment = InternmentProcess::updateOrCreate(
                ['application_id'   => $request->application_id, ],
                [
                    'agent_name'            => $request->agent_name,
                    'customs_house'         => $request->customs_house,
                    'agent_payment'         => $request->agent_payment,
                    'certificate'           => $request->certificate,
                ]
            );


            // agregar datos de subida de archivo
            // $data = new FileStore;
            // $file_storage = $data->addFile($request);

            foreach ($request->input('dataLoad') as $key => $data) {

                InternmentLoad::updateOrCreate(
                    ['internment_id' => $internment->id],
                    [
                        'cbm'            => $data['cbm'],
                        'length_unit'    => $data['lengthUnit'],
                        'length'         => $data['length'],
                        'width'          => $data['width'],
                        'high'           => $data['high'],
                        'mode_calculate' => $data['mode_calculate'],
                        'mode_selected'  => $data['mode_selected'],
                        'type_container' => $data['type_container'],
                        'type_load'      => $data['type_load'],
                        'weight'         => $data['weight'],
                        'weight_units'   => $data['weight_units'],
                        'stackable'      => $data['stackable'],
                    ]
                );
             }
    
             DB::commit();

            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'Error'], 400);
        }

        return response()->json($transport->id, 200);
        


    }
}
