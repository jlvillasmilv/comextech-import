<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransCompany;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\TransCompaniesRequest;
use Illuminate\Support\Facades\Gate;

class TransCompanyController extends Controller
{
    public function index()
    {
        if (! Gate::allows('trans_companies.index')) {
            return abort(401);
        }
        
        return view('admin.trans_companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('trans_companies.create')) {
            return abort(401);
        }

        return view('admin.trans_companies.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransCompaniesRequest $request)
    {
        $data = new TransCompany;
        $data->user_id = auth()->user()->id;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Registro agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.trans_companies.edit', $data->id);
    }

    
    public function show($id)
    {
        $data  = TransCompany::findOrFail($id);

        return view('admin.trans_companies.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('trans_companies.edit')) {
            return abort(401);
        }

        $data  = TransCompany::findOrFail($id);

        return view('admin.trans_companies.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(TransCompaniesRequest $request, $id)
    {
        $data = TransCompany::findOrFail($id);
        $data->modified_user_id = auth()->user()->id;
        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.trans_companies.edit', $data->id);
    }

   
    public function destroy($id)
    {
        //
    }
}
