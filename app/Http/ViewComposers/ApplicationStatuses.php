<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\ApplicationStatus;

class ApplicationStatuses {

	public function compose(View $view)
	{

                $status = ApplicationStatus::select('id', 'name')
                ->orderBy('name', 'ASC')
                ->pluck('name','id');
                        
                $view->with('status',  $status);
 

	}
}