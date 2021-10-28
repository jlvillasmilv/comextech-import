<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Factoring\{Application,Disbursement};

class TotalDisbursementsClient {

	public function compose(View $view)
	{
         
        if(auth()->user()->hasRole('Client')) {

            $disbursement = Application::has('disbursement', '>=', 1 )
            ->where([
                ['user_id', '=', auth()->user()->id],
                ['status', 'Aprobada'],
            ])->get();

            //sum of total amount of disbursements with different status pending and rejected
            $total_amount   = Disbursement::Approved()->select('disbursements.total_amount')->sum('total_amount');

            //sum of surplus disbursements with different status pending and rejected
            $surplus = Disbursement::Approved()
                        ->join('factoring_invoices', 'factoring_applications.id', '=', 'factoring_invoices.factoring_application_id')
                        ->select('factoring_invoices.surplus')->sum('surplus');
            $total_mora = 0;

            foreach ($disbursement as $key => $application) {
                $date_payment = is_null($application->disbursement->date_payment) ? date("Y-m-d") : $application->disbursement->date_payment;
                # code...

                foreach ($application->invoices as $invoice)  {
                    $rate  = $invoice->feesHistory->mora_rate / 100;
                    $mount = $invoice->total_amount * ( $invoice->feesHistory->discount / 100);
                    $expire_date = $invoice->expire_date;
                    $date1 = date_create($expire_date);
                    $date2 = date_create($date_payment);
                    $payment_real = date_diff($date1, $date2);

                    $mora = ($payment_real->format("%r%a") * $mount *  $rate) /30 ;

                    $mora = $mora <= 0 ? 0 : $mora;

                    $total_mora += $mora;
                }
            }

            $view->with('disbursement',  $disbursement->count()?? 0);
            $view->with('total_amount',  $total_amount);
            $view->with('surplus',  0 );
            $view->with('surplus',  $surplus - $total_mora );
            $view->with('total_mora',  number_format($total_mora,0,",","."));
    
        }
         
        
        
 

	}
}