<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CompanyAddress;
use App\Http\Requests\Web\CompanyAddressRequest;
use Illuminate\Http\Request;

class CompanyAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CompanyAddress::where('company_id', auth()->user()->company->id)
        ->where('status', 1)->paginate();
        return view('address.index' , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('address.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = new CompanyAddress;
        $address->fill($request->all());
        $address->save();

        $notification = array(
            'message'    => 'Registro agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('address.edit', $address->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyAddress  $companyAddress
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companyAddress = CompanyAddress::findOrFail($id); 
        return view('address.show', compact('companyAddress'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyAddress  $companyAddress
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companyAddress = CompanyAddress::findOrFail($id); 
        return view('address.form', compact('companyAddress'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyAddress  $companyAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $address = CompanyAddress::findOrFail($id);

        $address->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('address.edit', $address->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyAddress  $companyAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = CompanyAddress::findOrFail($id);
        $address->status = 0;
        $address->save();

        $notification = array(
            'message'    => 'Registro eliminado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('address.index');
    }

}
