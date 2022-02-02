<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\{CompanyAddress, Port};
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

        $id_ports = array();
        foreach (auth()->user()->ports as $menu) {
            //obteniendo los datos de un menu específico
            $id_ports[] = $menu->id;
        }

        $ports = Port::join('countries as c', 'ports.country_id', '=', 'c.id')
        ->where('ports.country_id', auth()->user()->company->country_id)
        ->where('ports.type', 'P')
        ->whereNotIn('ports.id', $id_ports)
        ->select('ports.id', \DB::raw("CONCAT(ports.name,' ',c.name,' (', ports.unlocs,')') AS name"))
		->orderBy('ports.name', 'ASC')
		->get();

        return view('profile.address.index' , compact('data','ports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.address.form');
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
        $address->company_id = auth()->user()->company->id;
        $address->fill($request->all());
        $address->save();

        $notification = array(
            'message'    => 'Registro agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('address.edit', base64_encode($address->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyAddress  $companyAddress
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companyAddress = CompanyAddress::findOrFail(base64_decode($id)); 
        return view('profile.address.show', compact('companyAddress'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyAddress  $companyAddress
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $companyAddress = CompanyAddress::findOrFail(base64_decode($id)); 
        return view('profile.address.form', compact('companyAddress'));
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
        $address = CompanyAddress::findOrFail(base64_decode($id));

        $address->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('address.edit', base64_encode($address->id));

    }

    public function addPorts(Request $request)
    {
        auth()->user()->ports()->attach($request->input('port_id'));

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('address.index');

    }

    public function delPorts($id)
    {   
        auth()->user()->ports()->detach([$id]);

        $notification = array(
            'message'    => 'Registro eliminado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('address.index');

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
