<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TransportModesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('trans_companies.index')) {
            return abort(401);
        }
        
        return view('admin.trans_modes.index');
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
     * @param  \App\Models\TransportMode  $transportMode
     * @return \Illuminate\Http\Response
     */
    public function show(TransportMode $transportMode)
    {
        return view('admin.trans_modes.show', compact('transportMode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransportMode  $transportMode
     * @return \Illuminate\Http\Response
     */
    public function edit(TransportMode $transportMode)
    {
        if (! Gate::allows('trans_companies.edit')) {
            return abort(401);
        }

        return view('admin.trans_modes.form', compact('transportMode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransportMode  $transportMode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransportMode $transportMode)
    {
        $transportMode->fill($request->all())->save();

        $notification = array(
            'message'    => 'Registro actualizado',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return redirect()->route('admin.transport-modes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransportMode  $transportMode
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransportMode $transportMode)
    {
        //
    }
}
