<?php

namespace App\Http\Controllers\Admin\Rates;

use App\Http\Controllers\Controller;
use App\Models\RateLocalTransport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\Rates\RateAirRequest;

class LocalTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\RateLocalTransport  $rateLocalTransport
     * @return \Illuminate\Http\Response
     */
    public function show(RateLocalTransport $rateLocalTransport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RateLocalTransport  $rateLocalTransport
     * @return \Illuminate\Http\Response
     */
    public function edit(RateLocalTransport $rateLocalTransport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RateLocalTransport  $rateLocalTransport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RateLocalTransport $rateLocalTransport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RateLocalTransport  $rateLocalTransport
     * @return \Illuminate\Http\Response
     */
    public function destroy(RateLocalTransport $rateLocalTransport)
    {
        //
    }
}
