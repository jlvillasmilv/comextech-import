<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Application,ApplicationDetail, ApplicationStatus};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin.applications.index')) {
            return abort(401);
        }

        return view('admin.applications.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data  = Application::findOrFail($id);

        return view('admin.applications.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {

        return view('admin.applications.form', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = Application::findOrFail($id);

        $status = ApplicationStatus::where('id', $data->application_statuses_id)->firstOrFail();

        if(!$status->modify){

            $notification = array(
                'message'    => 'No puede modificar solicitud '. $status->name,
                'alert_type' => 'error',);
    
            \Session::flash('notification', $notification);
    
            return redirect()->route('admin.applications.edit', $data->id);

        }

        if($data->status != $request->get('application_statuses_id')){

            $status2= ApplicationStatus::where('id',  $request->get('application_statuses_id'))->firstOrFail();

            if($status->rank > $status2->rank){

                $notification = array(
                    'message'    => 'No puede modificar desembolso a status menor' ,
                    'alert_type' => 'error',);
        
                \Session::flash('notification', $notification);
        
                return redirect()->route('admin.applications.edit', $data->id);
    
            }
        }

        $data->application_statuses_id = $request->application_statuses_id;
        $data->modified_user_id = auth()->user()->id;
        $data->save();

        if(isset($request->detail_id)){

            foreach ($request->detail_id as $key => $id) {

                ApplicationDetail::updateOrCreate(
                    ['application_id' => $data->id,
                    'service_id'     => $request->service_id[$key]
                    ],
                    [
                    'currency_id'  => $request->currency_id[$key],
                    'amount'       => $request->amount[$key],
                    'currency2_id' => $request->currency2_id[$key],
                    'amount2'      => $request->amount2[$key],
                    ]
                );
            }
        }

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.applications.edit', $data->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
