<?php

namespace App\Http\Controllers\Client;

use App\Models\{FileStore, FileStoreInternment, Service, InternmentProcess, Load};
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\InternmentProcessRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CustomController extends Controller
{
    /**
     * @author Jorge Villasmil.
     *
     * Generate a new or Update internment processes data in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
    */
    public function internmentProcesses(InternmentProcessRequest $request)
    {
        DB::beginTransaction();

        try {
           
            $internment = InternmentProcess::updateOrCreate(
                [   'application_id'       => $request->application_id, ],
                [
                    'custom_agent_id'      => $request->custom_agent_id,
                    'customs_house'        => $request->customs_house,
                    'agent_payment'        => $request->agent_payment,
                    'trans_company_id'     => $request->trans_company_id,
                    'courier_svc'          => $request->courier_svc,
                    'iva'                  => $request->iva,
                    'iva_amt'              => $request->iva ? round($request->iva_amt, 0) : 0, 
                    'adv'                  => $request->adv,
                    'adv_amt'              => $request->adv ? round($request->adv_amt, 0) : 0,
                    'cif_amt'              => $request->cif_amt,
                    'insurance'            => $request->insurance,
                    'port_charges'         => $request->port_charges,
                    'transport_amt'        => $request->transport_amt,
                    'tax_comex'            => $request->tax_comex,
                ]
            );

            $add_serv = Service::join('category_services as cs', 'services.category_service_id' , 'cs.id')
            ->where('cs.code', $request->code_serv)
            ->where('services.summary', false)
            ->select('services.id')
            ->pluck('services.id');
 
            foreach ($add_serv as $key => $id) {

                $mount = $key == 0 ? $request->agent_payment : 0 ;
                $mount = ($key == 1 && $request->iva ) ? round($request->iva_amt, 0) : $mount ;
                $mount = ($key > 1 && $request->adv ) ? round($request->adv_amt, 0) : $mount ;

             // update application summary
              $service_id = $key == 0 ? 'CS04-02' :($key == 1 ? 'CS04-03' : 'CS04-04');
              $tax_status = !$internment->tax_comex && $service_id != 'CS04-02' ? 0: 1;
              \DB::table('application_summaries as as')
                    ->join('services as s', 'as.service_id', '=', 's.id')
                    ->where([
                        ["as.application_id", $request->application_id],
                        ["s.code",  $service_id]
                    ])
                ->update(['as.amount' =>  $mount,
                  'as.currency_id' =>  $key == 0 ? 8:1,
                  'as.status' => $tax_status
                ]);

             }

              // update AGA
              \DB::table('application_summaries as as')
                    ->join('services as s', 'as.service_id', '=', 's.id')
                    ->where([
                        ["as.application_id", $request->application_id],
                        ["s.code",  'CS04-05']
                    ])
                ->update(['as.amount' =>  $request->port_charges,  'as.currency_id' =>  8]);

            // agregar datos de subida de archivo
            if ($request->hasFile('files')) {
                
                foreach ($request->input('file_descrip') as $key => $file) {

                    // $data_check =  ['internment_id' => $internment->id, 'intl_treaty' =>  $file.'-'.$request->application_id.'-'.$internment->id];
                
                    // FileStoreInternment::checkFileExists($data_check);
                    
                    $data = new FileStore;
                    $file_storage = $data->addFile(
                        $request->file('files')[$key],
                        $file.'-'.$request->application_id.'-'.$internment->id);

                    FileStoreInternment::updateOrCreate(
                        [
                            'file_store_id' => $file_storage->id,
                            'internment_id' => $internment->id,
                        ],
                        [ 'intl_treaty' => $file ]
                    );
                   
                }
            }

            if ($request->hasFile('file_certificate')) {

                // $data_check =  ['internment_id' => $internment->id, 'intl_treaty' => $request->certificate];
                
                // FileStoreInternment::checkFileExists($data_check);
                
                    $data = new FileStore;
                    $file_storage = $data->addFile(
                        $request->file('file_certificate'),
                        $request->certificate.'-'.$request->application_id.'-'.$internment->id);

                    FileStoreInternment::updateOrCreate(
                        [
                            'file_store_id' => $file_storage->id,
                            'internment_id' => $internment->id,
                        ],
                        [ 'intl_treaty' => $request->certificate, ]
                    );

            }

            //Agrega datos a carga de transporte
            if($request->input('transport')=='true' && count($request->input('dataLoad')) > 0 ){
                
                Load::cargo($request->input('dataLoad'),$request->application_id);
            }
        
            DB::commit();

        } catch (Throwable $e) {
             DB::rollback();
             return response()->json($e, 500);
        }

        return response()->json([
            'file_store_internment' => $internment->fileStoreInternment,
            'loads'                 => $internment->application->loads], 200);
    }

    public function downloadAsset($id, $type = null)
    {
        $file_store_internment = FileStoreInternment::where('internment_id', $id)
        ->where('intl_treaty', $type)->firstOrFail();
       
        return Storage::disk('s3')->response('file/'.$file_store_internment->fileStore->file_name);

    }

    public function removeFile($internment_id, $intl_treaty)
    {
        try{
            DB::beginTransaction();

            $file_store_internment = FileStoreInternment::where('internment_id', $internment_id)
            ->where('intl_treaty', $intl_treaty)->firstOrFail();

            $exists = Storage::disk('s3')
            ->exists('file/'.$file_store_internment->fileStore);

            if($exists){
            //     Storage::disk('s3')
            //     ->delete('file/'.$file_store_internment->fileStore);
            }

            FileStoreInternment::where('id',$file_store_internment->id)->delete();
            FileStore::where('id',$file_store_internment->file_store_id)->delete();

            DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
            return response()->json($e, 500);
        }

        return response()->json(['status' => 'OK'], 200);
    }
    
}
