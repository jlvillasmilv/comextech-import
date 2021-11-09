<?php

namespace App\Http\Controllers\Admin\Factoring;

use App\Http\Controllers\Controller;
use App\Models\Factoring\{Disbursement, FileDisbursement, DisbursementStatus};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Notifications\ClientDisbursementNotification;


class DisbursementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin.factoring.disbursements.index')) {
            return abort(401);
        }

        return view('admin.factoring.disbursements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin.factoring.disbursements.create')) {
            return abort(401);
        }

        return view('admin.factoring.disbursements.form');
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
     * @param  \App\Models\Factoring\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('admin.factoring.disbursements.show')) {
            return abort(401);
        }

        $data  = Disbursement::findOrFail(base64_decode($id));

        $date_payment = is_null($data->date_payment) ? date("Y-m-d") : $data->date_payment;



        return view('admin.factoring.disbursements.show', compact('data','date_payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factoring\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('admin.factoring.disbursements.edit')) {
            return abort(401);
        }

        $status = ['PENDIENTE','GIRO PENDIENTE','RECHAZADO','DESEMBOLSADO', 'EN MORA','PAGADO'];

        $data  = Disbursement::findOrFail(base64_decode($id));

        $date_payment = is_null($data->date_payment) ? date("Y-m-d") : $data->date_payment;

        return view('admin.factoring.disbursements.form', compact('data','status','date_payment','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factoring\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data  = Disbursement::findOrFail(base64_decode($id));

        $status = DisbursementStatus::where('name', $data->status)->firstOrFail();

        $date_payment = $request->get('status') == 'PAGADO' ? is_null($data->date_payment)  ? date('Y-m-d') : $data->date_payment : null;

        if(!$status->modify){

            $notification = array(
                'message'    => 'No puede modificar Desembolso '. $status->name,
                'alert_type' => 'error',);
    
            \Session::flash('notification', $notification);
    
            return redirect()->route('admin.factoring.disbursements.edit', $data->id);

        }


        if($data->status != $request->get('status')){

            $status2= DisbursementStatus::where('name', $request->get('status'))->firstOrFail();

            if($status->rank > $status2->rank){

                $notification = array(
                    'message'    => 'No puede modificar desembolso a status menor' ,
                    'alert_type' => 'error',);
        
                \Session::flash('notification', $notification);
        
                return redirect()->route('admin.factoring.disbursements.edit', base64_encode($data->id));
    
            }


            if($request->get('status') == 'PAGADO' or $request->get('status') == 'RECHAZADO'){

                $date_payment =   is_null($data->date_payment)  ? date('Y-m-d') : $data->date_payment;
        
                    $details = [
                        'title' => 'Estimado '.$data->application->user->name,
                        'body'  => 'Su solicitud de desembolso con numero N° '.str_pad($data->id, 6, '0', STR_PAD_LEFT).' ah sido:'.$data->status
                    ];
                    
                    \Mail::to($data->application->user->email)->send(new \App\Mail\Factoring\ApplicationReceived($details));

                    $user = $data->application->user;
                    $user->notify(new ClientDisbursementNotification($data));

            }

        }

        $data->date_payment =  $date_payment;
        $data->modified_users_id = auth()->user()->id;
        $data->fill($request->all());
        $data->save();
 

        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.factoring.disbursements.edit', base64_encode($data->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factoring\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disbursement $disbursement)
    {
        //
    }

    public function downloadAsset($id, $type = null)
    {

        $file_contract = FileDisbursement::where('disbursement_id', $id)
        ->where('type', $type)->first();

        //  header("Cache-Control: public");
        //  header("Content-Description: File Transfer");
        //  header("Content-Type: " . $file_contract->FileStore->mime_type);
         
         return Storage::disk('s3')->response('file/'.$file_contract->FileStore->original_name);

    }
}
