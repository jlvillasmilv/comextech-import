<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\User;

class ExecutiveComposer {

	public function compose(View $view)
	{
		
        $executive = User::role('BusinessExecutive')->pluck('name','id');
        $view->with('executive',  $executive);
		
	}
}
