<?php

namespace App\Http\Controllers\Factoring;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use App\Models\User;
use App\Models\Factoring\{Application, Disbursement, InvoiceHistory, Setting, Payer, ClientPayer, Client, Libredte};
use App\Notifications\AdminDisbursementNotification;
use Carbon\Carbon;

class ApplicationController extends Controller
{
  
    public function index()
    {   
        $applications = Application::where('user_id', auth()->user()->id )->orderBy('id', 'desc')->get();
       
        return view('factoring.application.index', compact('applications'));

    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $applications = Application::where([
            ['id', '=', $id],
            ['client_id', auth()->user()->client->id],
        ])->firstOrFail();

        return view('application.show', compact('applications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $application = Application::where([
            ['id', '=', $id],
            ['client_id', auth()->user()->client->id],
        ])->firstOrFail();

        $data = Application::findOrFail($id);
        $data->disbursement_status = true;
        $data->save();
       
        $disbursement= Disbursement::updateOrCreate(
            ['application_id' =>  $application->id],
            [
                'application_id' =>  $application->id,
                'total_amount'   =>  $application->invoices->sum('disbursement'),
                'writing_date'   => date('Y-m-d'),
                'created_users_id' => auth()->user()->id
            ]
        );

        $user_admin = User::whereHas('roles', function ($query) {
            $query->where('name','!=', 'client');
        })->pluck('id');

        User::all()
            ->whereIn('id', $user_admin)
            ->each(function (User $user) use ($disbursement) {
                $user->notify(new AdminDisbursementNotification($disbursement));
            });

        return  response()->json(['aviso' => 'OK'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function libredte(Request $request)
    {
      
        $invoices = auth()->user()->InvoicesHistory()->whereDate('factoring_invoice_histories.created_at', Carbon::today())->get();
        // $client   = auth()->user()->client;
        // $invoices = $client->InvoicesHistory()->whereDate('invoice_histories.created_at', Carbon::today())->get();
        $response = ['status' => 200 ];

        if ($invoices->isEmpty()) {
            
            $reqst = [
                'client_id'    =>  auth()->user()->id,
                'urlb'         => 'https://api.libredte.cl/api/v1/sii/rcv/ventas/detalle',
                'url_end'      => '/0?formato=json&certificacion=0&tipo=rcv_csv',
                'month'        => 3,
                'type'         => 'VENTAS'
            ];
            
            $data = new Libredte;

            $response = $data->PurchaseSalesRecord($reqst);
            
        }
         
        $data = $response['status'] == 200 
        ? Payer::InvoicesLastThreeMonths()->orderBy('fecha', 'DESC')->get()->toArray() 
        : $response['msg'];
        
         return  response()->json($data , $response['status']);
    }


}
