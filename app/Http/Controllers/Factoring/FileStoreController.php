<?php

namespace App\Http\Controllers\Factoring;
use App\Http\Controllers\Controller;

use App\Models\Factoring\{
        CredentialStore,
        FeesHistory,
        Setting,
        Payer,
        Invoice,
        Application, 
        ClientPayer
    };

use App\Models\FileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class FileStoreController extends Controller
{
 
    /**
     * @param Request $request
     * Método para cargar archivos XML del cliente en sistema.
     * Recibe los siguientes parámetros: ('type') tipo de archivo,
     * ('file') xml carga de archivo.
     * @author Gian Vespa
     */
    public function addFileClient(Request $request)
    {
        // verified file from frontend
        if ($request->hasFile('file')) {

            // redy file xml
            $data = [];
            $xmlfile = file_get_contents($request->file('file'));
  
                // Convert xml string into an object
                $new = simplexml_load_string($xmlfile);
                
                // Convert into json
                $con = json_encode($new);
                
                // Convert into associative array
                $newArr = json_decode($con, true);

                
           // $file_xml = simplexml_load_file($request->file('file'));
            $array = isset($newArr['SetDTE']['DTE'])? $newArr['SetDTE']['DTE']  : $newArr;

            $emitter_rut = $array['Documento']['Encabezado']['Emisor']['RUTEmisor'];

            $client =  auth()->user();
            
            $dte = (int)$array['Documento']['Encabezado']['IdDoc']['TipoDTE'];
           
            if($dte < 33 ||  $dte > 34){
                return response()->json(['status' => 'Factura no tiene condición de pago a crédito!'], 201);
            }

            if($emitter_rut !=  auth()->user()->company->tax_id){
                return response()->json(['status' => 'Factura no pertenece a la empresa registrada!'], 201);
            }

            $reqst = [
               'rut'          => $emitter_rut,
               'payer'        => $array['Documento']['Encabezado']['Receptor']['RznSocRecep'],
               'number'       => $array['Documento']['Encabezado']['IdDoc']['Folio'],
               'total_amount' => $array['Documento']['Encabezado']['Totales']['MntTotal'],
               'issuing_date' => $array['Documento']['Encabezado']['IdDoc']['FchEmis'],
               'expire_date'  => $array['Documento']['Encabezado']['IdDoc']['FchVenc'],
               'user_id'      =>  auth()->user()->id
            ];
            $data = new Application;

            return response()->json($data->calculateInvoice($reqst), 200);

        }
        return response()->json(['aviso' => 'archivo no encontrado'], 401);        
    }

    public function calc(Request $request)
    {    
        $date =  date("Y-m-d",strtotime($request->input('issuing_date')."+ 45 days"));

        $reqst = [
            'rut'          => $request->input('rut'),
            'payer'        => $request->input('payer'),
            'number'       => $request->input('number'),
            'total_amount' => $request->input('total_amount'),
            'issuing_date' => $request->input('issuing_date'),
            'expire_date'  => $request->input('expire_date') ?? $date ,
            'payment_date' => $request->input('payment_date') ?? $date ,
            'user_id'      => auth()->user()->id
         ];
         
         $data = new Application;
         return response()->json($data->calculateInvoice($reqst), 200);

    }

    public function anticipate(Request $request)
    {
        try {

            DB::beginTransaction();
            $client = auth()->user()->client;
            $application = new Application;
            $application->client_id = $client->id;
            $application->save();

            foreach($request->items as $key => $item) {

                $payer = Payer::firstOrCreate(
                    ['rut'       => $item['rut']],
                    ['name'      => $item['payer']],
                );

                

                $clientPayer = ClientPayer::firstOrCreate(
                    ['payer_id'  => $payer->id, 'client_id' => $client->id],
                );
               
                
                $feeInformation = [
                    'rate'      => $item['rate'],
                    'mora_rate' => $item['mora_rate'],
                    'discount'  => $item['discount'],
                    'commission'=> $item['commission'],
                    'fee_date'  => date('Y-m-d'),
                    'client_payers_id' => $clientPayer->id
                ];
             
                
                $fee_history = FeesHistory::firstOrCreate(
                    ['client_payer_id'  =>  $clientPayer->id],
                    $feeInformation
                );
          
                $invoice = new Invoice;
                $invoice->application_id = $application->id;
                $invoice->payer_id = $payer->id;
                $invoice->type_invoice_id = $request->input('source');
                $invoice->fees_histories_id = $clientPayer->feeshistory->last()->id;
                $invoice->number = $item['number'];
                $invoice->total_amount = $item['total_amount'];
                $invoice->price_difference = $item['dif'];
                $invoice->disbursement = $item['disbursement'];
                $invoice->surplus = $item['surplus'];
                $invoice->payment_real = $item['payment_real']['d'];
                $invoice->issuing_date =  $item['issuing_date'];
                $invoice->expire_date = $item['expire_date'];
                $invoice->save();
            }
    
            
            $data = [ 
                    'user'        => $client->id, 
                    'application' => $application
                ];

            $details = [
                'title' => 'Estimado '.$client->full_name,
                'body'  => 'Se ha creado una solicitud con numero N° '. $application->id.' por un total de $'.  number_format($application->invoices->sum('total_amount'),2,",",".") .' Esta Solicitu requiere una evaluación y aprobación para su ejecución Esta solicitud será respondida a su correo electronico registrado'
            ];
                
            \Mail::to(auth()->user()->email)->send(new \App\Mail\ApplicationReceived($details));

            DB::commit();
    
        } catch (Throwable $e){
            DB::rollBack();
            return  response()->json($e, 500);
        }

        return  response()->json( $data  ,200);
 
    }

    public function addFile(Request $request)
    {
        $file  = $request->file('file');

        $file_name = time() . '_' . $file->getClientOriginalName();
        Storage::disk('s3')->put('file/'.$file_name, \File::get($file));
        
        $fileStorage = FileStore::create([
            'disk'      =>  Storage::disk('s3')->url('file/'.$file_name),
            'file_name' => $file_name,
            'mime_type' => $file->getMimeType(),
        ]);

        $client_id = is_null($request->input('client_id')) ? auth()->user()->id :$request->input('client_id') ;

        $fileStorage->FileStoreClient()->create([
            'type'          => $request->input('type'),
            'user_id'       => $client_id,
            'file_store_id' => $fileStorage->id
        ]);

        return $fileStorage;
        
    }

    public function libredte(Request $request)
    {
        // 100210

        $client     = auth()->user();
        $credential = $client->credentialStores()->where('provider_name', 'SII')->get();
        $credential = !isset($credential[0])? false : $credential[0];
        $company    = $client->company;
        
        if(!$credential){
            return response()->json(['status' => 'Ingrese su contraseña del SII, haz tu proceso mas facil'], 401);
        }

        if(is_null($company->rut) or strlen($company->rut) <= 0){
            return response()->json(['status' => 'Ingrese datos empresariales!'], 401);
        }

        $setting = Setting::firstOrFail();

        if(strlen($setting->api_sii) <= 4){
            return response()->json(['status' => 'no url Sii'], 401);
        }

        if(strlen($setting->token_sii) <= 4){
            return response()->json(['status' => 'no Token Sii'], 401);
        }

        $rut   = $company->rut;
        $pass  = $credential['provider_password'];
        $urlb  = $setting->api_sii;
        $token = $setting->token_sii;
        $period = (int)date('Ym');
        

       $responseMerged = array();

       for ($i = 1; $i <= 3; $i++) {

        $url = $urlb.'/'.$rut.'/'.$period.'/0?formato=json&certificacion=0&tipo=rcv_csv';

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "auth": {
                "pass": {
                    "rut": "'.$rut.'",
                    "clave": "'.$pass.'"
                }
            }
        }
        ',
          CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token,
                'Content-Type: application/json',
                'Accept: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $validate = json_decode($response, true);

         
        if(array_key_exists('message', $validate) ){
            return response()->json(['status' => $validate['message']], 401);
            die();
        }
        $responseMerged = array_merge($responseMerged, json_decode($response));
        
         curl_close($curl);

         $period =  $period-1; 

        }
        
        array_multisort(array_column($responseMerged, 'folio'), SORT_DESC, $responseMerged);
        
        return  response()->json( $responseMerged  ,200);
    }
}