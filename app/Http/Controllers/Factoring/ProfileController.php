<?php

namespace App\Http\Controllers\Factoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('factoring.profile.index');
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
