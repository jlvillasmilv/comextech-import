<?php

namespace App\Http\Controllers\Admin\Factoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\PayersExport;
use Maatwebsite\Excel\Facades\Excel;


class PayerController extends Controller
{
    public function export() 
    {
        return  Excel::download(new PayersExport, 'pagadores_cuotas'.time() . '_' .'.xlsx');
        
    }
}
