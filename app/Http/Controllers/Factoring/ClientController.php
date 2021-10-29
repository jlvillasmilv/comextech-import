<?php

namespace App\Http\Controllers\Factoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    // 
    public function index()
    {
        return view('profile.index');
    }
    public function show($id)
    {
        $client  = auth()->user()->client;
        $client->company;
        $client->bankAccounts;
        $client->credentialStores;
        return response()->json($client, 200);
    }

}
