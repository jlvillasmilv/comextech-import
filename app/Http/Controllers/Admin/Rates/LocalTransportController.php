<?php

namespace App\Http\Controllers\Admin\Rates;

use App\Http\Controllers\Controller;
use App\Models\RateLocalTransport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\Rates\{LocalTransportRequest, ImportRateRequest};

class LocalTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin.rates.local_transport.index')) {
            return abort(401);
        }
        
        return view('admin.rates.local_transport.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin.rates.local_transport.create')) {
            return abort(401);
        }

        return view('admin.rates.local_transport.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocalTransportRequest $request)
    {
        $data = new RateLocalTransport;
        $data->user_id = auth()->user()->id;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Registro Agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.rates.local-transport.edit', base64_encode($data->id));
    }

   
    public function show($id)
    {
        if (! Gate::allows('admin.rates.local_transport.show')) {
            return abort(401);
        }

        $data  = RateLocalTransport::findOrFail(base64_decode($id));

        return view('admin.rates.local_transport.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RateLocalTransport
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('admin.rates.local_transport.edit')) {
            return abort(401);
        }

        $data  = RateLocalTransport::findOrFail(base64_decode($id));

        return view('admin.rates.local_transport.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function update(LocalTransportRequest $request, $id)
    {
        $data = RateLocalTransport::findOrFail(base64_decode($id));
        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.rates.local-transport.edit', base64_encode($data->id));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = RateLocalTransport::findOrFail(base64_decode($id));
        $data->status = false;
        $data->save();

    }
}
