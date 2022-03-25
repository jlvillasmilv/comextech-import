<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\{Company, Country, CompanyAddress};
use App\Http\Requests\Web\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (! Gate::allows('client.company.index')) {
            return abort(401);
        }

        $data = Company::where('id', auth()->user()->company->id)->firstOrFail();

        $country = Country::OrderBy('name')
                ->select('id', 'name')
                ->orderBy('name', 'ASC')
                ->pluck('name','id');
                
        return view('profile.company' , compact('data','country'));

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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        if (! Gate::allows('client.company.edit')) {
            return abort(401);
        }

        $data = Company::findOrFail(base64_decode($id));

        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('company.index');

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

    /**
    * Busqueda de direeciones asociadas a una compañia.
    *
    */
    public function address()
    {
        $address = CompanyAddress::where('company_id', auth()->user()->company->id)->get();

        return response()->json($address, 200);
    }
}
