<?php

namespace App\Exports;

use App\Models\Factoring\{ClientPayer};

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;


class PayersExport implements FromView 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.factoring.payers.index', [
            'ClientPayer' => ClientPayer::all()
        ])->with(null, null, 'A1', false, false);
     
    }
    
}
