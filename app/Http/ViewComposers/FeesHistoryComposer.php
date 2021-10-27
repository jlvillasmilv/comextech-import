<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\User;

class FeesHistoryComposer {

        public function compose(View $view)
	{

                $payers = User::whereHas('roles', function ($query) {
                                $query->where('name','=', 'client');
                        })->pluck('name','id');
                        
                $view->with('payers',  $payers);
 
	}
}
