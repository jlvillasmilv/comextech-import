<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Notifications\AdminConnectionLog;
use Carbon\Carbon;

class Libredte extends Model
{
    protected $table = 'factoring_connection_libredte';

    protected $guarded = [];


    public function rut($rut)
    {

        // 76722268-8 empresa.
        // 76829802-5 empresa
        // 5024234-k persona
        // 77069957-6
        // 3160Isijav
        // 13026763-7 Andres Fabregat 100210 76722268-8

        $setting = Setting::firstOrFail();

            if(strlen($setting->token_sii) <= 10){
                return response()->json(['status' => 'no Token Sii'], 403);
            }

            $log = $this::whereDate('created_at', '=', date('Y-m-d'))->first();

            $token = $setting->token_sii;

            $url = 'https://api.libredte.cl/api/v1/sii/contribuyentes/situacion_tributaria/tercero/'.$rut;

            $httpResponse = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json',])->get($url);


            $limit = isset($httpResponse->headers()['X-RateLimit-Limit'][0]) ? $httpResponse->headers()['X-RateLimit-Limit'][0] : 0;
            $count_limit = isset($httpResponse->headers()["X-RateLimit-Remaining"][0]) ? $httpResponse->headers()["X-RateLimit-Remaining"][0] : 0 ;

            $this->where('id', $log->id)
            ->update(['limit' => $limit , 'remaining' => $count_limit]);

            $response = $httpResponse->body();

            ConexionLog::create([
                'user_id' => 0,
                'type'    => 'RUT',
                'provider_name' => 'SII'
            ]);

          return $response;

    }


    public function PurchaseSalesRecord($data)
    {

            $log = $this->firstOrCreate(
                ['date_limit' =>  date('Y-m-d')],
                ['limit' => 0, 'remaining' => 500]
            );

            $client     = \App\Models\User::findOrFail($data['client_id']);
            $credential = $client->credentialStores()->where('provider_name', 'SII')->first();
           
            $company    = $client->company;
            $setting    = \App\Models\Setting::firstOrFail();
            $credential = is_null($credential) ? false : $credential->toArray();
            //validar datos

           // dd(base64_decode($credential['provider_password']));
           

            $validated = [
                'Ingrese su contraseña del SII, haz tu proceso mas facil' => !$credential,
                'No posee datos Empresariales' => is_null($company->tax_id) or strlen($company->tax_id) <= 0,
                'No tiene credenciales Sii configuradas' => strlen($setting->api_sii) <= 4 or strlen($setting->token_sii) <= 4
            ];

            foreach ($validated as $key => $value) {
                if($value){
                    return ['status' => 403, 'msg' => $key];
                }
            }
            //variables
            $rut    = $company->tax_id;
            $pass   = base64_decode($credential['provider_password']);
            $token  = $setting->token_sii;
            $period = Carbon::now();
            $month  = $data['month'];
            $responseMerged = array();


        for ($i = 1; $i <= $month; $i++) {

            $log = $this::whereDate('created_at', '=', date('Y-m-d'))->first();

            $url = $data['urlb'].'/'.$rut.'/'.$period->format('Ym').$data['url_end'];

            $body = '{
                "auth": {
                    "pass": {
                        "rut": "'.$rut.'",
                        "clave": "'.$pass.'"
                    }
                }
            }';


            https://api.libredte.cl/api/v1/sii/rcv/ventas/detalle/76722268-8/202110/0?formato=json&certificacion=0&tipo=rcv_csv

            $httpResponse = Http::withToken($token)
                ->withBody($body, 'application/json')
                ->withHeaders([
                    'Accept' => 'application/json',
                ])->post($url);

            $validate = json_decode($httpResponse, true);

            if(array_key_exists('message', $validate) ){

                $msg = $validate['code'] !== 401 ? 'Api LibreDTE se encuentra en mantenimiento!' : $validate['message'];
                return ['status' => 403, 'msg' => $msg ];
            }

            $limit = isset($httpResponse->headers()['X-RateLimit-Limit'][0]) ? $httpResponse->headers()['X-RateLimit-Limit'][0] : 0;
            $count_limit = isset($httpResponse->headers()["X-RateLimit-Remaining"][0]) ? $httpResponse->headers()["X-RateLimit-Remaining"][0] : 0 ;

            $this->where('id', $log->id)
            ->update(['limit' => $limit , 'remaining' => $count_limit]);


            foreach (json_decode($httpResponse->body()) as $key => $item) {


                $payer = Payer::firstOrCreate(
                    ['rut'  =>  $item->rut],
                    ['name' =>  $item->razon_social]
                );

                if( $data['type'] == 'VENTAS'){

                    $clientPayer = ClientPayer::firstOrCreate(
                        ['payer_id'=>  $payer->id, 'user_id' => $client->id]
                    );

                    $clientPayer->InvoiceHistory()->updateOrCreate(
                        ['client_payer_id' => $clientPayer->id, 'folio' =>  $item->folio ],
                        [
                            'dte'              =>  $item->dte,
                            'tipo_transaccion' =>  $item->tipo_transaccion,
                            'fecha'            =>  $item->fecha,
                            'fecha_recepcion'  =>  $item->fecha,
                            'fecha_acuse'      =>  $item->fecha_acuse,
                            'fecha_reclamo'    =>  $item->fecha_reclamo,
                            'exento'           =>  $item->exento,
                            'neto'             =>  $item->neto,
                            'iva'              =>  $item->iva,
                            'total'            =>  $item->total,
                            'iva_retencion_total'   =>  $item->iva_retencion_total,
                            'iva_retencion_parcial' =>  $item->iva_retencion_parcial,
                            'iva_no_retenido'       =>  $item->iva_no_retenido,
                            'iva_propio'            =>  $item->iva_propio,
                            'iva_terceros'          =>  $item->iva_terceros,
                            'liquidacion_rut'       =>  $item->liquidacion_rut,
                            'liquidacion_comision_neto'   =>  $item->liquidacion_comision_neto,
                            'liquidacion_comision_exento' =>  $item->liquidacion_comision_exento,
                            'liquidacion_comision_iva'    =>  $item->liquidacion_comision_iva,
                            'iva_fuera_plazo'       =>  $item->iva_fuera_plazo,
                            'referencia_tipo'       =>  $item->referencia_tipo,
                            'referencia_folio'      =>  $item->referencia_folio,
                            'extranjero_id'         =>  $item->extranjero_id,
                            'extranjero_nacionalidad'  =>  $item->extranjero_nacionalidad,
                            'credito_constructoras'    =>  $item->credito_constructoras,
                            'ley_18211'             =>  $item->ley_18211,
                            'deposito_envases'      =>  $item->deposito_envases,
                            'indicador_sin_costo'   =>  $item->indicador_sin_costo,
                            'indicador_servicio'    =>  $item->indicador_servicio,
                            'monto_no_facturable'   =>  $item->monto_no_facturable,
                            'monto_periodo'         =>  $item->monto_periodo,
                            'pasaje_nacional'       =>  $item->pasaje_nacional,
                            'pasaje_internacional'  =>  $item->pasaje_internacional,
                            'numero_interno'        =>  $item->numero_interno,
                            'sucursal_sii'          =>  $item->sucursal_sii,
                            // 'emisor_nc_nd_fc'  =>  $item->emisor_nc_nd_fc,
                        ]
                    );

                }


                if( $data['type'] == 'COMPRAS'){
                    PurchaseHistory::updateOrCreate(
                        ['client_id' => $client->id, 'folio' =>  $item->folio ],
                        [
                            'dte'              =>  $item->dte,
                            'tipo_transaccion' =>  $item->tipo_transaccion,
                            'payer_id'         =>  $payer->id,
                            'fecha'            =>  $item->fecha,
                            'fecha_recepcion'  =>  $item->fecha,
                            'fecha_acuse'      =>  $item->fecha_acuse,
                            'exento'           =>  $item->exento,
                            'neto'             =>  $item->neto,
                            'iva'              =>  $item->iva,
                            'iva_no_recuperable_monto'   =>  $item->iva_no_recuperable_monto,
                            'iva_no_recuperable_codigo'  =>  $item->iva_no_recuperable_codigo,
                            'total'                      =>  $item->total,
                            'monto_activo_fijo'          =>  $item->monto_activo_fijo,
                            'monto_iva_activo_fijo'      =>  $item->monto_iva_activo_fijo,
                            'iva_uso_comun'              =>  $item->iva_uso_comun,
                            'impuesto_sin_credito'       =>  $item->impuesto_sin_credito,
                            'iva_no_retenido'            =>  $item->iva_no_retenido,
                            'impuesto_puros'             =>  $item->impuesto_puros,
                            'impuesto_cigarrillos'       =>  $item->impuesto_cigarrillos,
                            'impuesto_tabaco_elaborado'  =>  $item->impuesto_tabaco_elaborado
                        ]
                    );
                }

            }

            $period = $period->subMonth(1);

            ConexionLog::create([
                'user_id' => auth()->user()->id,
                'type'    => 'RCV',
                'provider_name' => 'SII'
            ]);

        }

        return ['status' => 200, 'msg' => 'OK'];

    }


    public function notification()
    {
        $user_admin = User::whereHas('roles', function ($query) {
            $query->where('name','=', 'super_admin');
        })->pluck('id');

        User::all()
        ->whereIn('id', $user_admin)
        ->each(function (User $user) {
            $user->notify(new AdminConnectionLog());
        });
    }
}
