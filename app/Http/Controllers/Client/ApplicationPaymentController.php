<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ApplicationPayment;
use Illuminate\Http\Request;

class ApplicationPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //account-statement

        return view('client.account-statement.index');
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
     * @param  \App\Models\ApplicationPayment  $applicationPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationPayment $applicationPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplicationPayment  $applicationPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationPayment $applicationPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicationPayment  $applicationPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationPayment $applicationPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApplicationPayment  $applicationPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationPayment $applicationPayment)
    {
        //
    }
}
