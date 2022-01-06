<?php

namespace App\Http\Controllers\Admin\Rates;

use App\Http\Controllers\Controller;
use App\Models\RateLCE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\Rates\{LocalSpendingRequest, ImportRateRequest};

class LocalSpendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin.rates.local_spending.index')) {
            return abort(401);
        }
        
        return view('admin.rates.local_spending.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin.rates.local_spending.create')) {
            return abort(401);
        }

        return view('admin.rates.local_spending.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocalSpendingRequest $request)
    {
        $data = new RateLCE;
        $data->user_id = auth()->user()->id;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Registro Agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.rates.local-spending.edit', base64_encode($data->id));
    }

   
    public function show($id)
    {
        if (! Gate::allows('admin.rates.local_spending.show')) {
            return abort(401);
        }

        $data  = RateLCE::findOrFail(base64_decode($id));

        return view('admin.rates.local_spending.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('admin.rates.local_spending.edit')) {
            return abort(401);
        }

        $data  = RateLCE::findOrFail(base64_decode($id));

        return view('admin.rates.local_spending.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function update(LocalSpendingRequest $request, $id)
    {
        $data = RateLCE::findOrFail(base64_decode($id));
        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.rates.local-spending.edit', base64_encode($data->id));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = RateLCE::findOrFail(base64_decode($id));
        $data->status = false;
        $data->save();

    }

    public function fileImport(ImportRateRequest $request) 
    {
        if($request->hasFile('file')){ 
            try {
               
               Excel::import(new RateLCE, $request->file('file'), \Maatwebsite\Excel\Excel::CSV);
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
