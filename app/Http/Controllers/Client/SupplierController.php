<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\{Supplier, SupplierAddress};
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Supplier::where('user_id', auth()->user()->id)->paginate();
        return view('supplier.index' , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $supplier = new Supplier;
        $supplier->fill($request->all());
        $supplier->user_id = auth()->user()->id;
        $supplier->save();

        $supplier->ports()->sync($request->input('port_id'));

        if($request->has('origin_address')){
            foreach ($request->input('origin_address') as $key => $value) {
                $supplier->supplierAddress()->create([
                    'address' => $value,
                    'place'   => $request->place[$key],
                    'latitude'  => $request->latitude[$key],
                    'longitude' => $request->longitude[$key],
                    'postal_code'       => $request->postal_code[$key],
                    ]);
            }
        }

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('supplier.edit', $supplier->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.form', compact('supplier'));
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

        $supplier = Supplier::findOrFail($id);

        $supplier->fill($request->all())->save();

        $supplier->ports()->sync($request->input('port_id'));

        if($request->has('origin_address')){
            foreach ($request->input('origin_address') as $key => $value) {
                $supplier->supplierAddress()->create([
                    'address' => $value,
                    'place'   => $request->place[$key],
                    'latitude'  => $request->latitude[$key],
                    'longitude' => $request->longitude[$key],
                    'postal_code'       => $request->postal_code[$key],
                    ]);
            }
        }

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('supplier.edit', $supplier->id);

    }

    public function list()
    {
        $data = Supplier::where('user_id', auth()->user()->id)->get(['id','name']);
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
        Supplier::findOrFail($id)->delete();
        return  response()->json(null, 204);
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        SupplierAddress::findOrFail($request->id)->delete();
        return  response()->json(null, 200);
    }
}
