<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{User,Application, ApplicationDetail ,Service};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\Web\ApplicationRequest;
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
                    'estimated_date' => $request->estimated_date,
                ]
            );


            foreach ($request->services as $key => $service) {

                $add_serv = Service::where([
                    ['status', true],
                    ['category_service_id', $service["id"]],
                ])->get();

                foreach ($add_serv as $key => $add) {

                    ApplicationDetail::updateOrCreate(
                        ['application_id' => $data->id,
                        'service_id'   => $add["id"],
                        ],
                        [
                            'currency_id'  => $data->currency_id,
                            'amount'       => 0,
                            'currency2_id' => $data->currency_id,
                            'estimated'  => date('Y-m-d')
                        ]
                    );

                }

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
}
