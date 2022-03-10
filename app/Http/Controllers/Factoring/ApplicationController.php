<?php

namespace App\Http\Controllers\Factoring;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use App\Models\User;
use App\Models\Factoring\{Application, Disbursement, InvoiceHistory, Setting, Payer, ClientPayer, Client, Libredte};
use App\Notifications\AdminDisbursementNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
  
    public function index()
    {   

        if (! Gate::allows('factoring.applications.index')) {
            return abort(401);
        }
        
        $applications = Application::where('user_id', auth()->user()->id)
        ->orderBy('id', 'desc')
        ->paginate(7);
       
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
        if (! Gate::allows('factoring.applications.show')) {
            return abort(401);
        }

        $applications = Application::where([
            ['id', '=', base64_decode($id)],
            ['user_id', auth()->user()->id],
        ])->firstOrFail();

        return view('factoring.application.show', compact('applications'));
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

        if (! Gate::allows('factoring.applications.edit')) {
            return abort(401);
        }

        $application = Application::where([
            ['id', '=', base64_decode($id)],
            ['user_id', auth()->user()->id],
        ])->firstOrFail();

        

        $data = Application::findOrFail(base64_decode($id));
        $data->disbursement_status = true;
        $data->save();
       
        $disbursement= Disbursement::updateOrCreate(
            ['factoring_application_id' =>  $application->id],
            [
                'total_amount'     =>  $application->invoices->sum('disbursement'),
                'writing_date'     => date('Y-m-d'),
                'created_users_id' => auth()->user()->id
            ]
        );

        $user_admin = User::whereHas('roles', function ($query) {
            $query->where('name','!=', 'Client');
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
      
        $invoices = auth()->user()->InvoicesHistory()
        ->whereDate('factoring_invoice_histories.created_at', Carbon::today())
        ->whereTime('factoring_invoice_histories.created_at' , '<',Carbon::now()->subHours(1))
        ->get();
        
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
