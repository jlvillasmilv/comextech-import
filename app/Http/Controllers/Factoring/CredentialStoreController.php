<?php

namespace App\Http\Controllers\Factoring;

use Illuminate\Http\Request;
use App\Http\Requests\Web\Factoring\UpdateCredentialRequest;
use App\Http\Controllers\Controller;

class CredentialStoreController extends Controller
{
    public function index($name_provider)
    {
        $client     = auth()->user();
        $credential = $client->credentialStores()
        ->where('provider_name', $name_provider)
        ->select('id', 'provider_password','provider_name')
        ->first();

        $credential = !isset($credential) ? [ 'id'=> null, 'provider_password' => null] : 
        [ 'id'=> $credential->id, 
         'provider_password' => base64_decode($credential->provider_password)];
         
        return  response()->json(['client' => $client,'credential' => $credential] , 200);
    }

    public function store(UpdateCredentialRequest $request, $id)
    { 
        $reponse = $request->updateOrCreate($id);

        return response()->json($reponse, 200);
        
    }
}
