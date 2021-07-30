<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class SupplierComposer {

	public function compose(View $view)
	{

        $place = ['ALMACEN', 'FABRICA', 'PUERTO'];
                        
        $view->with('place',  $place);
 
	}
}