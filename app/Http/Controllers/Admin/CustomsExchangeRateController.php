<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomsExchangeRate;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CustomsExchangeRateRequest;
use Illuminate\Support\Facades\Gate;

class CustomsExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('customs_exchange_rates.index')) {
            return abort(401);
        }
        
        return view('admin.customs_exchange_rates.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('customs_exchange_rates.create')) {
            return abort(401);
        }

        return view('admin.customs_exchange_rates.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomsExchangeRateRequest $request)
    {
        $data = new CustomsExchangeRate;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Registro Agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.customs-exchange-rates.edit', base64_encode($data->id));
    }

   
    public function show($id)
    {
        if (! Gate::allows('customs_exchange_rates.show')) {
            return abort(401);
        }

        $data  = CustomsExchangeRate::findOrFail(base64_decode($id));

        return view('admin.customs_exchange_rates.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('customs_exchange_rates.edit')) {
            return abort(401);
        }

        $data  = CustomsExchangeRate::findOrFail(base64_decode($id));

        return view('admin.customs_exchange_rates.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomsExchangeRate  
     * @return \Illuminate\Http\Response
     */
    public function update(CustomsExchangeRateRequest $request, $id)
    {
        ddd($request->all());
        $data = CustomsExchangeRate::findOrFail(base64_decode($id));
        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.customs-exchange-rates.edit', base64_encode($data->id));
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomsExchangeRate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = CustomsExchangeRate::findOrFail(base64_decode($id));
        $data->status = false;
        $data->save();

    }
}
