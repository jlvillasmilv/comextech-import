<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ApplicationCondSale,CategoryService};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationCondSaleController extends Controller
{
    public function index()
    {
        if (! Gate::allows('suppl_cond_sales.index')) {
            return abort(401);
        }
        
        return view('admin.suppl_cond_sales.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('suppl_cond_sales.create')) {
            return abort(401);
        }

        $cserv = CategoryService::select('id', 'name')
        ->where('status', '=', true)
        ->orderBy('name', 'ASC')
        ->pluck('name','id');

        return view('admin.suppl_cond_sales.form', compact('cserv'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new ApplicationCondSale;
        $data->user_id = auth()->user()->id;
        $data->fill($request->all());
        $data->save();

        $notification = array(
            'message'    => 'Registro Agregado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.suppl_cond_sales.edit', $data->id);
    }

   
    public function show($id)
    {

        if (! Gate::allows('suppl_cond_sales.show')) {
            return abort(401);
        }

        $data  = ApplicationCondSale::with('services')->findOrFail($id);

        return view('admin.suppl_cond_sales.show', compact('data'));
    }

    
    public function edit($id)
    {
        if (! Gate::allows('suppl_cond_sales.edit')) {
            return abort(401);
        }

        $data  = ApplicationCondSale::findOrFail($id);

        $cserv = CategoryService::select('id', 'name')
        ->where('status', '=', true)
        ->orderBy('name', 'ASC')
        ->pluck('name','id');

        return view('admin.suppl_cond_sales.form', compact('data','cserv'));
    }

    public function update(Request $request, $id)
    {

        //dd($request->all());
        $data = ApplicationCondSale::findOrFail($id);
        $data->modified_user_id = auth()->user()->id;
        $data->fill($request->all())->save();

         $services = $request->input('services') ? $request->input('services') : '';
         $data->services()->sync($services);

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.suppl_cond_sales.edit', $data->id);
    }
    
    public function destroy($id)
    {
        $data = ApplicationCondSale::findOrFail($id);
        $data->status = false;
        $data->save();

    }
}
