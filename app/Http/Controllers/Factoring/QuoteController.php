<?php

namespace App\Http\Controllers\Factoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Factoring\{
    Application, 
    ClientPayer,
    FeesHistory,
    Payer,
    Invoice
};

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('factoring.quote.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quotation()
    {
        return view('factoring.quote.quote');
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
     * @param  \App\Models\Factoring\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factoring\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factoring\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
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


    public function anticipate(Request $request)
    {
        try {

            DB::beginTransaction();
            $client = auth()->user()->id;

            $application = new Application;
            $application->user_id = auth()->user()->id;
            $application->save();

            foreach($request->items as $key => $item) {

                $payer = Payer::firstOrCreate(
                    ['rut'       => $item['rut']],
                    ['name'      => $item['payer']],
                );

                $clientPayer = ClientPayer::firstOrCreate(
                    ['payer_id'  => $payer->id, 'user_id' => auth()->user()->id],
                );
               
                
                $feeInformation = [
                    'rate'      => $item['rate'],
                    'mora_rate' => $item['mora_rate'],
                    'discount'  => $item['discount'],
                    'commission'=> $item['commission'],
                    'fee_date'  => date('Y-m-d'),
                    'client_payers_id' => $clientPayer->id
                ];
             
                
                $fee_history = FeesHistory::firstOrCreate(
                    ['client_payer_id'  =>  $clientPayer->id],
                    $feeInformation
                );
          
                $invoice = new Invoice;
                $invoice->factoring_application_id = $application->id;
                $invoice->factoring_payer_id = $payer->id;
                $invoice->type_invoice_id = $request->input('source');
                $invoice->fees_histories_id = $clientPayer->feeshistory->last()->id;
                $invoice->number = $item['number'];
                $invoice->total_amount = $item['total_amount'];
                $invoice->price_difference = $item['dif'];
                $invoice->disbursement = $item['disbursement'];
                $invoice->surplus = $item['surplus'];
                $invoice->payment_real = $item['payment_real']['d'];
                $invoice->issuing_date =  $item['issuing_date'];
                $invoice->expire_date = $item['expire_date'];
                $invoice->save();
            }
    
            
            $data = [ 
                    'user'        => auth()->user()->email, 
                    'application' => $application->code
                ];

            $details = [
                'title' => 'Estimado '.auth()->user()->name,
                'body'  => 'Se ha creado una solicitud con numero N?? '.$application->code.' por un total de $'.  number_format($application->invoices->sum('total_amount'),2,",",".") .' Esta Solicitud requiere una evaluaci??n y aprobaci??n para su ejecuci??n Esta solicitud ser?? respondida a su correo electronico registrado'
            ];
                
            \Mail::to(auth()->user()->email)->send(new \App\Mail\Factoring\ApplicationReceived($details));

            DB::commit();
    
        } catch (Throwable $e){
            DB::rollBack();
            return  response()->json($e, 500);
        }

        return  response()->json($data  ,200);
 
    }

    public function calc(Request $request)
    {    
        $date =  date("Y-m-d",strtotime($request->input('issuing_date')."+ 45 days"));

        $reqst = [
            'rut'          => $request->input('rut'),
            'payer'        => $request->input('payer'),
            'number'       => $request->input('number'),
            'total_amount' => $request->input('total_amount'),
            'issuing_date' => $request->input('issuing_date'),
            'expire_date'  => $request->input('expire_date') ?? $date ,
            'payment_date' => $request->input('payment_date') ?? $date ,
            'user_id'      => auth()->user()->id
         ];
         
         $data = new Application;
         return response()->json($data->calculateInvoice($reqst), 200);

    }
}
