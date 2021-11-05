<?php

namespace App\Http\Controllers\Admin\Factoring;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\Factoring\FeesHistoryRequest;
use Illuminate\Http\Request;
use App\Models\Factoring\{FeesHistory, Payer, ClientPayer, Client};
use App\Models\{User, Setting};
use Maatwebsite\Excel\Facades\Excel;

class FeesHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin.factoring.fees_history.index')) {
            return abort(401);
        }

        return view('admin.factoring.fee_history.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin.factoring.fees_history.create')) {
            return abort(401);
        }

        $clients = User::has('company')->pluck('name','id');

        return view('admin.factoring.fee_history.form', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payer = Payer::firstOrCreate(
            ['rut' => $request->input('rut')],
            ['name' => $request->input('name')],
        );
        
        $clientPayer = ClientPayer::firstOrCreate(
            [
                'payer_id' => $payer->id,
                'user_id'  => $request->input('user_id')
            ]
        );

        $fee = Setting::first();

        $clientPayer->FeesHistory()->create([
            'rate'       => $fee->rate,
            'mora_rate'  => $fee->mora_rate,
            'discount'   => $fee->discount,
            'commission' => $fee->commission,
            'fee_date'   =>  date('Y-m-d'),
        ]);

        // if(is_null($clientPayer))
        // {
        //     $clientPayer = new ClientPayer;
        //     $clientPayer->payer_id = $payer->id;
        //     $clientPayer->client_id = $request->input('client_id'); 
        //     $clientPayer->save(); 
        //     $fee = Setting::first(); 
         
        //     $clientPayer->FeesHistory()->create([
        //         'rate'       => $fee->rate,
        //         'mora_rate'  => $fee->mora_rate,
        //         'discount'   => $fee->discount,
        //         'commission' => $fee->commission,
        //         'fee_date'   =>  date('Y-m-d'),
        //     ]);
        // }
        return view('admin.factoring.fee_history.index');

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

        $data  = ClientPayer::findOrFail(base64_decode($id));
     
        return view('admin.factoring.fee_history.show', compact('data'));
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
        
        $data =  ClientPayer::findOrFail(base64_decode($id));
        $clients = User::has('company')->pluck('name','id');
     
        return view('admin.factoring.fee_history.form', compact('data','id','clients'));
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
       
        $data = Payer::findOrFail(base64_decode($id));

        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return  redirect()->route('admin.factoring.fee_history.edit', base64_encode($data->id));
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
        $fee    = FeesHistory::findOrFail($id);
        $data   = $fee->ClientPayer;
        $id     = base64_encode($data->id);

        $clients = User::has('company')->pluck('name','id');
       
        return view('admin.factoring.fee_history.form', compact('data','fee','clients','id'));
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
 // antecedentes
        $data = $fee->ClientPayer;
    
        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

            \Session::flash('notification', $notification);
 
        return  redirect()->route('admin.factoring.fee_history.edit', base64_encode($data->id));

    }


    /**
     * Import fee history from .xlsx
     *
     */
    public function import() 
    { 
        
        try {
            Excel::Import(new FeesHistoryImport, request()->file('payers_excel'));

            $notification = array(
                'message'    => 'Actualizacion Exitosa!',
                'alert_type' => 'success',
            );
            \Session::flash('notification', $notification);

            return redirect('admin/factoring/fee_history')
            ->with('status', 'Informacion de Bases de Calculos Actualizada!');
        } catch (\Throwable $th) {

            $notification = array(
                'message'    => 'Error al actualizar informacion!',
                'alert_type' => 'error',
            );
            \Session::flash('notification', $notification);
            
            return redirect('admin/factoring/fee_history')
            ->with('error', 'Tu archivo no cumple con los requisitos!');
             
        }
            
    }
}
