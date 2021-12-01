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
                      ->where('sp.type', 'P')
                      ->select('sp.id', \DB::raw("CONCAT(sp.name,' ',c.name,' (', sp.unlocs,')') AS name"))
                      ->orderBy('sp.id')
                      ->get();
          
          return response()->json($ports, 200);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PortSupplier(Request $request, $id)
    {
          $ports = \DB::table('ports_suppliers as ps')
                      ->join('ports as p', 'ps.port_id', '=', 'p.id')
                      ->join('countries as c', 'p.country_id', '=', 'c.id')
                      ->where('p.status', true)
                      ->where('p.type', 'P')
                      ->where('ps.supplier_id' , $id) 
                      ->select('p.id', \DB::raw("CONCAT(p.name,' ',c.name,' (', p.unlocs,')') AS name"))
                      ->orderBy('p.id')
                      ->get();
          
          return response()->json($ports, 200);
    }

     /**
     * Display a list port user selected.
     *
     * @return \Illuminate\Http\Response
     */
    public function seaPortUser(Request $request)
    {
          $ports = \DB::table('ports_users as ps')
                      ->join('ports as p', 'ps.port_id', '=', 'p.id')
                      ->join('countries as c', 'p.country_id', '=', 'c.id')
                      ->where('p.status', true)
                      ->where('p.type', 'P')
                      ->where('ps.user_id' , auth()->user()->id) 
                      ->select('p.id', \DB::raw("CONCAT(p.name,' ',c.name,' (', p.unlocs,')') AS name"))
                      ->orderBy('p.id')
                      ->get();
          
          return response()->json($ports, 200);
    }
    
   
}
