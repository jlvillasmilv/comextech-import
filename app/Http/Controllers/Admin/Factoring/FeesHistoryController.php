<?php

namespace App\Http\Controllers\Admin\Factoring;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Factoring\{FeesHistory, ClientPayer};
use App\Http\Requests\Factoring\FeesHistoryRequest;
use Illuminate\Http\Request;

class FeesHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Factoring\FeesHistory  $feesHistory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('admin.factoring.fees_history.show')) {
            return abort(401);
        } 

        $data    = ClientPayer::findOrFail($id);
     
        return view('admin.fee_history.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factoring\FeesHistory  $feesHistory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('admin.factoring.fees_history.edit')) {
            return abort(401);
        } 
        
        $data    =  ClientPayer::findOrFail($id);
     
        return view('admin.fee_history.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factoring\FeesHistory  $feesHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('admin.factoring.fees_history.edit')) {
            return abort(401);
        } 
       
        $data = Payer::findOrFail($id);

        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return  redirect()->route('admin.fee_history.edit', $data->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factoring\FeesHistory  $feesHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeesHistory $feesHistory)
    {
        //
    }

    public function fee_edit($id)
    {
        
        $fee     = FeesHistory::findOrFail($id);
        $data    = $fee->ClientPayer;
       
        return view('admin.fee_history.form', compact('data','fee'));
    }

    public function fee_store(FeesHistoryRequest $request)
    {
       
        $fee = FeesHistory::updateOrCreate(
            ['id' =>  request('id')],
            [
                'client_payer_id'   => request('client_payer_id'),
                'rate'       => request('rate'),
                'mora_rate'  => request('mora_rate'),
                'discount'   => request('discount'),
                'commission' => request('commission'),
                'fee_date'   => date('Y-m-d')
            ]
        );

        $data = $fee->ClientPayer;
    
        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

            \Session::flash('notification', $notification);
 
        return  redirect()->route('admin.fee_history.edit', $data->id);

    }
}
