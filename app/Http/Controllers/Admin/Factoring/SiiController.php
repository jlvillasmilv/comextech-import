<?php

namespace App\Http\Controllers\Admin\Factoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Factoring\{InvoiceHistory, Libredte, Payer, PurchaseHistory, ClientPayer};
use App\Models\{User, Setting};
use App\Notifications\AdminDisbursementNotification;


class SiiController extends Controller
{
    public function __construct()
    {
        $log = Libredte::firstOrCreate(
            ['date_limit' =>  date('Y-m-d')],
            ['limit' => 500, 'remaining' => 500]
        );
    }

    public function rut(Request $request)
    { 
        $data = new Libredte;

        return $data->rut($request->get('rut'));
    }


    public function ventas_detalle(Request $request)
    {
        // 100210
        //dd($request->all());

        $client = User::findOrFail($request->get('client_id'));
       
        $reqst = [
            'client_id'    => $client->id,
            'urlb'         => 'https://api.libredte.cl/api/v1/sii/rcv/ventas/detalle',
            'url_end'      => '/0?formato=json&certificacion=0&tipo=rcv_csv',
            'month'        => $request->get('month'),
            'type'         => 'VENTAS'
         ];
         
        $data = new Libredte;

        $response = $data->PurchaseSalesRecord($reqst);

        return $response;
    }


    public function compras_detalle(Request $request)
    {

        $client = User::findOrFail($request->get('client_id'));

        $reqst = [
            'client_id'    => $client->id,
            'urlb'         => 'https://api.libredte.cl/api/v1/sii/rcv/compras/detalle',
            'url_end'      => '/0/REGISTRO?formato=json&certificacion=0&tipo=rcv_csv',
            'month'        => $request->get('month'),
            'type'         => 'COMPRAS'
         ];
         
        $data = new Libredte;

        $response = $data->PurchaseSalesRecord($reqst);

        return  $response;
       
    }

}
