<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreightQuote;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\FreightQuotesRequest;
use Illuminate\Support\Facades\Gate;

class FreightQuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin.freight_quotes.index')) {
            return abort(401);
        }
        
        return view('admin.freight_quotes.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin.freight_quotes.create')) {
            return abort(401);
        }

        return view('admin.freight_quotes.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomsExchangeRateRequest $request)
    {
        $data = new FreightQuote;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Registro Agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.freight-quotes.edit', base64_encode($data->id));
    }

   
    public function show($id)
    {
        if (! Gate::allows('freight_quotes.show')) {
            return abort(401);
        }

        $data  = FreightQuote::findOrFail(base64_decode($id));

        return view('admin.freight_quotes.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('admin.freight_quotes.edit')) {
            return abort(401);
        }

        $data  = FreightQuote::findOrFail(base64_decode($id));

        return view('admin.freight_quotes.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FreightQuote  
     * @return \Illuminate\Http\Response
     */
    public function update(FreightQuotesRequest $request, $id)
    {
        $data = FreightQuote::findOrFail(base64_decode($id));
        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.freight-quotes.edit', base64_encode($data->id));
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FreightQuotes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = FreightQuote::findOrFail(base64_decode($id));
        $data->save();

    }
}
