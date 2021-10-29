<?php

namespace App\Http\Controllers\Factoring;

use Illuminate\Http\Request;
use App\Http\Requests\Client\UpdateCredentialRequest;
use App\Http\Controllers\Controller;

class CredentialStoreController extends Controller
{
    public function index($name_provider)
    {
        $client     = auth()->user()->client;
        $credential = $client->credentialStores()->where('provider_name', $name_provider)->get();
        
        $credential = !isset($credential[0])? [ 'id'=> null, 'provider_password' => null] : $credential[0];
         
        return  response()->json(['client' => $client,'credential' => $credential] , 200);
    }

    public function store(UpdateCredentialRequest $request, $id)
    { 

        $reponse = $request->updateOrCreate($id);

        return response()->json($reponse, 200);
        
    }
}
