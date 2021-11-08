<?php

namespace App\Http\Controllers\Factoring;

use App\Http\Controllers\Controller;
use App\Models\Factoring\{Client, FileStoreClient};

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class FileStoreClientController extends Controller
{
    public function store(Request $request)
    {
    
        $file = new FileStoreController();
        $file_store = $file->addFile($request);
         
        return response()->json($file_store, 200);
    }

    public function show($name)
    {   
        $client  = auth()->user();
        $files   = $client->FileStoreClient()->where("type", $name)->get();
        $file    = $files->last();
        $name    = $file->FileStore->original_name;
        return Storage::disk('s3')->response('file/'.$name);
    }
    public function validatedFile($name)
    {   
        $files   = auth()->user()->FileStoreClient()
        ->where("type", $name)->get();
         
        return response()->json(['status' => $files], 200);
    }

   
}
