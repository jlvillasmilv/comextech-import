<?php

namespace App\Http\Controllers\Admin\Factoring;

use App\Events\Admin\Factoring\ApplicationStatusEvent;
use App\Http\Controllers\Controller;
use App\Models\Factoring\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\Factoring\ApplicationRequest;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin.factoring.applications.index')) {
            return abort(401);
        }

        return view('admin.factoring.application.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin.factoring.applications.create')) {
            return abort(401);
        }

        return view('admin.factoring.application.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        $data = new Application;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

            \Session::flash('notification', $notification);

        return view('admin.application.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factoring\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('admin.factoring.applications.show')) {
            return abort(401);
        }

        $data    = Application::findOrFail(base64_decode($id));

        $status = [
            1  => ['icon' => 'check-circle', 'color' => 'green'],
            0  => ['icon' => 'times-circle', 'color' => 'red'],
         ];

        return view('admin.factoring.application.show', compact('data','status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factoring\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('admin.factoring.applications.edit')) {
            return abort(401);
        }

        $status = ['Aprobada','En Proceso','Rechazada'];

        $data    = Application::findOrFail(base64_decode($id));

        return view('admin.factoring.application.form', compact('data','status','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factoring\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRequest $request, $id)
    {
        $data = Application::findOrFail(base64_decode($id));
        
        $notification = array(
            'message'    => 'No puede cambiar status ya tiene un desembolso',
            'alert_type' => 'warning',);


        if($data->disbursement_status == 0){
            $data->modified_users_id = auth()->user()->id;
            $data->fill($request->all())->save();

                if($data->status == 'Aprobada' or $data->status == 'Rechazada'){
        
                    $details = [
                        'title' => 'Estimado '.$data->user->name,
                        'body'  => 'la solicitud con numero N° '.str_pad($data->id, 6, '0', STR_PAD_LEFT) .' por un total de $'.  number_format($data->invoices->sum('total_amount'),0,",",".") .' ah sido '.$data->status.' '.$data->observation
                    ];
                    
                    \Mail::to($data->user->email)->send(new \App\Mail\Factoring\ApplicationReceived($details));

                    event(new ApplicationStatusEvent($data));
 
                }

            $notification = array(
                'message'    => 'Actualizacion Exitosa!',
                'alert_type' => 'success',);

        }

        \Session::flash('notification', $notification);

        return view('admin.factoring.application.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factoring\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
