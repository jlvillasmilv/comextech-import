<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{Application,Service};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\Web\ApplicationRequest;

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
        //dd($request->all());

        DB::beginTransaction();

        try {
            $data = new Application;
            $data->fill($request->all());
            $data->application_statuses_id = 1;
            $data->user_id = auth()->user()->id;
            $data->save();

            foreach ($request->services as $key => $service) {

                $add_serv = Service::where([
                    ['status', true],
                    ['category_service_id', $service["id"]],
                ])->get();

                foreach ($add_serv as $key => $add) {

                    $data->details()->create([
                        'service_id'  => $add["id"],
                        'amount'    => 0,
                        'estimated'  => date('Y-m-d')
                    ]);
                }

            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return response()->json(['status' => 'Error'], 400);
        }
      
    

        return response()->json(['status' => 'OK'], 200);
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
