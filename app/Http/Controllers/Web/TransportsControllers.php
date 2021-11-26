<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransportsControllers extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function seaPorts(Request $request)
    {
          $ports = \DB::table('ports as sp')
                      ->join('countries as c', 'sp.country_id', '=', 'c.id')
                      ->where('sp.status', true)
                      ->select('sp.id','sp.name','sp.unlocs','c.name as country')
                      ->orderBy('sp.id')
                      ->get();
          
          return response()->json($ports, 200);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seaPortCountry(Request $request)
    {
        if($flag=="true"){

            $code =  \DB::table('supplier_addresses')
              ->where('id', $id)
              ->select('country_code')
              ->first('country_code');
              $id = $code->country_code;
          }
     
          $ports = \DB::table('ports as sp')
                      ->join('countries as c', 'sp.country_id', '=', 'c.id')
                      ->where('sp.status', true)
                      ->where('c.code' , $id) 
                      ->select('sp.name','sp.province','c.name as country')
                      ->orderBy('sp.id')
                      ->get();
          
          return response()->json($ports, 200);
    }
    
   
}
