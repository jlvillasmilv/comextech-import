<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Application,ApplicationDetail,ApplicationSummary, ApplicationStatus, Service, FedexApi};
use App\Models\services\{DHL, DHLTracking };
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\{ApplicationRequest,ApplicationServiceRequest};

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin.applications.index')) {
            return abort(401);
        }

        return view('admin.applications.index');
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
    public function store(ApplicationServiceRequest $request)
    {

        $data = Application::findOrFail($request->application_id);

        $status = ApplicationStatus::where('id', $data->application_statuses_id)->firstOrFail();

        if(!$status->modify){

            return  response()->json(['errors' => ['services_id' => ['No puede modificar solicitud']]],422);
        }


        $data = new ApplicationDetail;
        $data->fill($request->all());
        $data->save();

        return  response()->json(['aviso' => 'OK'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application  = Application::findOrFail($id);


        return view('admin.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        $services = Service::join('category_services', 'services.category_service_id', '=', 'category_services.id')
        ->select('services.id', \DB::raw("CONCAT(category_services.name,' / ', services.name) as name_code"))
        ->whereNotIn('services.id', $application->details->pluck('service_id'))
        ->where('services.status', '=', true)
        ->orderBy('services.name', 'ASC')
        ->pluck('name_code','services.id');

        return view('admin.applications.form', compact('application','services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRequest $request, $id)
    {

        $data = Application::findOrFail($id);

        $status = ApplicationStatus::where('id', $data->application_statuses_id)->firstOrFail();

        if(!$status->modify){

            $notification = array(
                'message'    => 'No puede modificar solicitud '. $status->name,
                'alert_type' => 'error',);
    
            \Session::flash('notification', $notification);
    
            return redirect()->route('admin.applications.edit', $data->id);

        }

        if($data->status != $request->get('application_statuses_id')){

            $status2= ApplicationStatus::where('id',  $request->get('application_statuses_id'))->firstOrFail();

            if($status->rank > $status2->rank){

                $notification = array(
                    'message'    => 'No puede modificar desembolso a status menor' ,
                    'alert_type' => 'error',);
        
                \Session::flash('notification', $notification);
        
                return redirect()->route('admin.applications.edit', $data->id);
    
            }
        }

        // if(!isset($request->detail_id)){
        //     return back()->with('error', 'Debe tener al menos un servicio asociado');
        // }

        $data->application_statuses_id = $request->application_statuses_id;
        $data->modified_user_id = auth()->user()->id;
        $data->save();

        if ($data->transport->exists()) {

            $data->transport->update(['tracking_number' => $request->input('tracking_number') ]);
        }


       if(isset($request->detail_id)){

            foreach ($request->detail_id as $key => $id) {

                ApplicationSummary::where('id',  $id)
                    ->update([
                        'fee_date'     => $request->fee_date[$key],
                        'currency_id'  => $request->currency_id[$key],
                        'amount'       => $request->amount[$key],
                    ]);
            }
        }
    

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.applications.edit', $data->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ApplicationDetail::where('id', $id)->delete();
        return  response()->json(['aviso' => 'OK'],200);
    }

    public function tracking($id)
    {
        $application  = Application::findOrFail($id);

        // dd($application->transport->transCompany->name);


        switch ($application->transport->transCompany->name) {
            case 'DHL':
                $track = DHL::tracking($application->transport->tracking_number);

                $objJsonDocument = json_encode($track);
                $resp = json_decode($objJsonDocument, TRUE);
        
                if($resp['AWBInfo']['Status']['ActionStatus'] != "success"){

                    $notification = array(
                        'message'    => $resp['AWBInfo']['Status']['Condition']['ConditionData'],
                        'alert_type' => 'error',);
            
                    \Session::flash('notification', $notification);

                    return redirect()->route('admin.applications.index');

                }
                $data = $resp['AWBInfo'];
                $status= end($resp['AWBInfo']['ShipmentInfo']['ShipmentEvent']);
                

                return view('admin.applications.traking.dhl', compact('data','status'));

                break;

            case 'FEDEX':
                $data = FedexApi::tracking($application->transport->tracking_number);
                
                if($data->Notification->Severity != "SUCCESS"){

                    $notification = array(
                        'message'    => $data->Notification->Message,
                        'alert_type' => 'error',);
            
                    \Session::flash('notification', $notification);

                    return redirect()->route('admin.applications.index');

                }

                return view('admin.applications.traking.fedex', compact('data'));
                break;
            
            default:
                # code...
                break;
        }
     

    }
}