<?php

namespace App\Http\Controllers\Factoring;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Factoring\Partners\UpdateOrCreateRequest;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
         $client  = auth()->user();
         $company = $client->company;
         $company->partners;
        
         return response()->json($company, 200);
    }

    public function store(UpdateOrCreateRequest $request)
    {
        $reponse = $request->updateOrCreate();

        return response()->json($reponse, 200);
    }
    public function destroy($id)
    {
        $reponse = Partner::destroy($id);
        return response()->json($reponse, 200);
    }
}
