<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\{User, Application};

class AdminDashboard {

	public function compose(View $view)
	{
		$clients = User::role('Client')
		->with('application')
		->orderBy('id', 'desc')
		->limit(10)->get();
                        
        $view->with('clients',  $clients);

 
	}
}