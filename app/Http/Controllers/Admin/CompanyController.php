<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Company, CompanyAccountStatement, UserMarkUp};
use App\Models\Factoring\{ClientLegalInfo ,FileStoreClient};
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        if (! Gate::allows('clients.index')) {
            return abort(401);
        }

        return view('admin.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin.clients.create')) {
            return abort(401);
        }  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('admin.clients.create')) {
            return abort(401);
        }

        $data = new ClientLegalInfo;
        $data->fill($request->all());
        $data->user_id = auth()->user()->id;
        $data->save();

        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

            \Session::flash('notification', $notification);

        return redirect()->route('admin.clients.edit', $data->client->company->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('admin.clients.show')) {
            return abort(401);
        }

        $data  = Company::findOrFail($id);

        return view('admin.clients.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('admin.clients.edit')) {
            return abort(401);
        }

        $company  = Company::findOrFail($id);

        return view('admin.clients.form', compact('company'));
    }

    public function legal($id)
    {
        $data     = ClientLegalInfo::findOrFail($id);
        $company  = Company::where('user_id', $data->client_id)->firstOrFail();

        return view('admin.clients.form', compact('company','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
        if (! Gate::allows('admin.clients.edit')) {
            return abort(401);
        }

        $data = ClientLegalInfo::findOrFail($id);

        $data->fill($request->all());
        $data->user_id = auth()->user()->id;
        $data->save();

        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.clients.edit', $data->client->company->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    public function excutive(Request $request)
    {
        $company  = Company::findOrFail($request->input('id'));
        $company->fill($request->all());
        $company->save();

        $internment = UserMarkUp::updateOrCreate(
            [   'user_id' => $company->user->id, ],
            [
                'air'              => $request->air,
                'fcl'              => $request->fcl,
                'lcl'              => $request->lcl,
                'transfer_abroad'  => $request->transfer_abroad,
                'exch_rate_margin' => $request->exch_rate_margin,
            ]
        );

        CompanyAccountStatement::updateOrCreate(
            [   
                'company_id'    => $request->input('id'),
                'reference'     => '',
                'method_type'   => 'ABONO CREDITO',
                'movement_date' => date('Y-m-d'),
            ],
            [
                'debit'       => 0,
                'credit'      => $request->input('available_credit'),
            ]
        );

        $notification = array(
            'message'    => 'Datos modificados, exitosamente!',
            'alert_type' => 'success'
        );

        \Session::flash('notification', $notification);
        return redirect()->route('admin.clients.edit', $company->id);
    }

    public function clientDiscount(Request $request)
    {
        foreach ($request->input('discount_id') as $key => $item) {

           \DB::table('user_discounts')
                    ->where([
                        ["id",  $item],
                        ["user_id", $request->input('user_id')],
                    ])
            ->update([
                'imp_a' =>  $request->input("imp_a.$key"),
                'imp_b' =>  $request->input("imp_b.$key"),
                'imp_c' =>  $request->input("imp_c.$key"),
                'imp_d' =>  $request->input("imp_d.$key"),
                'imp_e' =>  $request->input("imp_e.$key"),
                'imp_f' =>  $request->input("imp_e.$key"),
                'exp_a' =>  $request->input("exp_a.$key"),
                'exp_b' =>  $request->input("exp_b.$key"),
                'exp_c' =>  $request->input("exp_c.$key"),
            ]);
        }

        $data  =  Company::findOrFail($request->input('company_id'));
        
        $notification = array(
            'message'    => 'Descuento asignado',
            'alert_type' => 'success'
        );

        \Session::flash('notification', $notification);
        return redirect()->route('admin.clients.edit', $data->id);
    }

    public function download_file($id)
    {
        $files   = FileStoreClient::where("id", $id)->first();
        $name    = $files->FileStore->original_name;
        return Storage::disk('s3')->response('file/'.$name);
    }

}
