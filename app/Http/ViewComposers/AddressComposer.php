<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\{Country};

class AddressComposer {

	public function compose(View $view)
	{
		$country = Country::OrderBy('name')
		->select('id', 'name')
		->orderBy('name', 'ASC')
		->pluck('name','id');

        $place = ['ALMACEN', 'FABRICA', 'PUERTO','OFICINA'];
                        
        $view->with('place',  $place);
		$view->with('country',  $country);
 
	}
}