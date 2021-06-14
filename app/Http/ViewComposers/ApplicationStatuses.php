<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\{ApplicationStatus, Currency};

class ApplicationStatuses {

	public function compose(View $view)
	{

                $status = ApplicationStatus::select('id', 'name')
                ->orderBy('name', 'ASC')
                ->pluck('name','id');
                        
                $view->with('status',  $status);

                $currencies = Currency::select('id', DB::raw("CONCAT(name,' (', code,')') as name_code"))
                ->where('status', '=', true)
                ->orderBy('name', 'ASC')
                ->pluck('name_code','id');
                        
                $view->with('status',  $status);
                $view->with('currencies',  $currencies);
 

	}
}