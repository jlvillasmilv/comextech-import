<?php

namespace App\Http\Controllers\Admin\Rates;

use App\Http\Controllers\Controller;
use App\Imports\Admin\Rate\FCLImport;
use App\Models\RateFcl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\Rates\{RateFCLRequest, ImportRateRequest};

class RateFCLController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('rates.fcl.index')) {
            return abort(401);
        }
        
        return view('admin.rates.fcl.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('rates.fcl.create')) {
            return abort(401);
        }

        return view('admin.rates.fcl.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RateFCLRequest $request)
    {
        $data = new RateFcl;
        $data->user_id = auth()->user()->id;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Registro Agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.rates.fcl.edit', base64_encode($data->id));
    }

   
    public function show($id)
    {
        if (! Gate::allows('rates.fcl.show')) {
            return abort(401);
        }

        $data  = RateFcl::findOrFail(base64_decode($id));

        return view('admin.rates.fcl.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('rates.fcl.edit')) {
            return abort(401);
        }

        $data  = RateFcl::findOrFail(base64_decode($id));

        return view('admin.rates.fcl.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function update(RateFCLRequest $request, $id)
    {
        $data = RateFcl::findOrFail(base64_decode($id));
        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.rates.fcl.edit', base64_encode($data->id));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = RateFcl::findOrFail(base64_decode($id));
        $data->status = false;
        $data->save();

    }

    public function fileImport(ImportRateRequest $request) 
    {
        if($request->hasFile('file')){ 
            try {
               
               Excel::import(new FCLImport, $request->file('file'), \Maatwebsite\Excel\Excel::CSV);
                $notification = array(
                    'message'    => 'Registro subidos con exito',
                    'alert_type' => 'success',);

            } catch (\Throwable $th) {

                $notification = array(
                    'message'    => 'Problemas para subir datos verifique su archivo',
                    'alert_type' => 'error',);
            }
        }
        else {
            $notification = array(
                'message'    => 'Seleccione un archivo valido',
                'alert_type' => 'error',);
        }
       
        \Session::flash('notification', $notification);

        return back();
    }
}
