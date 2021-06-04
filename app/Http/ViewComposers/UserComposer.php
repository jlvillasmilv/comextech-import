<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class UserComposer {

	public function compose(View $view)
	{

        $roles = \Spatie\Permission\Models\Role::select('id', 'name')
        ->orderBy('name', 'ASC')
        ->pluck('name','id');
		
        $view->with('roles',  $roles);
 

	}
}
