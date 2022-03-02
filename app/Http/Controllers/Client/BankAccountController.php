<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Http\Requests\BankAccountRequest;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_accounts = BankAccount::where('user_id', auth()->user()->id)
        ->with('bank')
        ->select('id',
        'bank_id',
        'number',
        'status')
        ->with([
            'bank' => function($query) {
                $query->select('id', 'name');
            }
        ])
        ->get();
    
        return response()->json($bank_accounts, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankAccountRequest $request)
    {
        $bankAccount =  BankAccount::updateOrCreate(
            [
                'id'        => $request->id,
                'user_id'   => auth()->user()->id,
            ],
            [
                'bank_id'       => $request->bank_id,
                'number'        => $request->number,
            ]
        );

        return response()->json($bankAccount, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankAccount = BankAccount::where([
            ['id', base64_decode($id)],
            ['user_id', auth()->user()->id],
            ])->firstOrFail(); 

        return response()->json($bankAccount, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(BankAccountRequest $request, $id)
    {
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bankAccount = BankAccount::where([
            ['id', base64_decode($id)],
            ['user_id', auth()->user()->id],
        ])->delete();

        return response()->json($bankAccount, 200);
    }
}
