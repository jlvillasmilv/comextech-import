<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class SupplierComposer {

	public function compose(View $view)
	{
		$ports =  \DB::table('ports')
		->join('countries as c', 'ports.country_id', '=', 'c.id')
		->where('ports.status', true)
		->where('ports.type', 'P')
        ->select('ports.id', \DB::raw("CONCAT(ports.name,' ',c.name,' (', ports.unlocs,')') AS name"))
		->orderBy('ports.name', 'ASC')
		->get();

        $place = ['ALMACEN', 'FABRICA', 'PUERTO'];
                        
        $view->with('place',  $place);
		$view->with('ports',  $ports);
 
	}
}