<?php

namespace App\Http\Controllers\Factoring;

use App\Models\UserCredential;
use Illuminate\Http\Request;
use App\Http\Requests\Web\Factoring\UpdateCredentialRequest;
use App\Http\Controllers\Controller;

class CredentialStoreController extends Controller
{
    public function index()
    {
        $client     = auth()->user();
        $credential = $client->credentialStores()
        ->select('id', 'provider_password','provider_name')
        ->first();

        $credential = !isset($credential) ? [ 'id'=> null, 'provider_password' => null] : 
        [ 'id'=> $credential->id, 
         'provider_password' => base64_decode($credential->provider_password)];
         
        return  response()->json(['client' => $client,'credential' => $credential] , 200);
    }

    public function store(UpdateCredentialRequest $request)
    { 
        $credential = UserCredential::updateOrCreate(
            [
               'user_id'           => auth()->user()->id,
               'provider_name'     => $request->input('providerName'),
            ],
            [   
                'provider_password' => base64_encode($request->input('password')),
            ],
        );

        return response()->json($credential, 200);
        
    }
}
