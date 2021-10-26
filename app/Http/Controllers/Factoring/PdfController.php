<?php

namespace App\Http\Controllers\Factoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Factoring\{Application, Disbursement};

class PdfController extends Controller
{
    public function assignment_contract($id){

        $application = Application::where('id', $id)->firstOrFail();
        $legal_info = $application->client
        ->client_legal_info
        ->where('created_at', '>=',  $application->disbursement->created_at)
        ->first();

        $pdf = \PDF::loadView('disbursements.pdf', compact('application', 'legal_info') );
        $pdf->setPaper("letter", "portrait");
        return $pdf->download('CONTRATO_CESION.pdf');

    }
}
