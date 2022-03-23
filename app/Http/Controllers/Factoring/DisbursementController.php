<?php

namespace App\Http\Controllers\Factoring;

use App\Models\Factoring\{Disbursement, Application, FileStore, FileDisbursement};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class DisbursementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('factoring.disbursements.index')) {
            return abort(401);
        }

        $applications = Application::has('disbursement', '>=', 1 )
        ->where([
            ['user_id', '=', auth()->user()->id],
            ['status', 'Aprobada'],
        ])->get();
       
        return view('factoring.disbursements.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('factoring.disbursements.create')) {
            return abort(401);
        }

        $request->validate([
            'file' => 'required|file|max:3000'
           ]);


        $data = new FileStore;
        $file_storage = $data->addFile($request);

        $file_record = FileDisbursement::where([
            ['disbursement_id', $request->input('disbursement_id')],
            ['type', $request->input('type')],
        ])->first();

        if(isset($file_record) > 0){

            $exists = Storage::disk(env('FILESYSTEM_DRIVER', 'local'))
            ->exists($file_record->FileStore->path);

            if($exists){
                Storage::disk(env('FILESYSTEM_DRIVER', 'local'))
                ->delete($file_record->FileStore->path);
            }

        }

        $fileInformation = [
            'type'            => $request->input('type'),
            'file_store_id'   => $file_storage->id
        ];



        $file_dis = FileDisbursement::updateOrCreate(
            ['disbursement_id' => $request->input('disbursement_id'),
             'type'            => $request->input('type')
            ],
            $fileInformation
        );

        return response()->json($file_dis->FileStore->path, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('factoring.disbursements.show')) {
            return abort(401);
        }

        $bankAccounts = auth()->user()->bankAccounts;

        $applications = Application::where([
            ['id', '=', base64_decode($id)],
            ['user_id', auth()->user()->id],
        ])->firstOrFail();

        $status = [
            1  => ['icon' => 'check-circle', 'color' => 'green'],
            0  => ['icon' => 'times-circle', 'color' => 'red'],
         ];
         
        return view('factoring.disbursements.show', compact('applications', 'status', 'bankAccounts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function edit(Disbursement $disbursement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disbursement $disbursement)
    {
        if (! Gate::allows('factoring.disbursements.edit')) {
            return abort(401);
        }

        $data = $disbursement->fill($request->all())->save();
        $id   = $request->input('bank_accounts_id') === null ? $disbursement->bank_accounts_id : $request->input('bank_accounts_id');
        $bankAccounts = auth()->user()->bankAccounts->where('id',$id )->first();

        return response()->json(['number'=> $bankAccounts->number, 'name'=>$bankAccounts->bank->name], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disbursement $disbursement)
    {
        //
        
    }
}
