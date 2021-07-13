<?php

namespace App\Http\Controllers;

use App\Models\CustomAgent;
use Illuminate\Http\Request;

class CustomAgentController extends Controller
{
    public function index()
    {
        return view('custom_agents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('custom_agents.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $data = new CustomAgent;
        $data->fill($request->all());
        $data->user_id = auth()->user()->id;
        $data->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('custom_agents.edit', $data->id);
    }

   
    public function show(CustomAgent $customAgent)
    {
        return view('custom_agents.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomAgent $customAgent)
    {
        return view('custom_agents.form', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        $data = CustomAgent::findOrFail($id);

        $data->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('custom_agents.edit', $data->id);

    }

    public function list()
    {
        $data = CustomAgent::where('user_id', auth()->user()->id)->get();
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomAgent::findOrFail($id)->delete();
        return response(null, 204);
    }
}
