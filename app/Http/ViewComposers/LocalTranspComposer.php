<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class LocalTranspComposer {

	public function compose(View $view)
	{
		$ports = DB::table('ports as p')
		->join('countries as c', 'c.id', '=', 'p.country_id')
		->where('c.code', 'CL')
		->select('p.unlocs', DB::raw("CONCAT(p.name,' (', p.unlocs,')') as name_code") )
		->orderBy('p.name', 'ASC')
		->pluck('name_code','unlocs');
		
		$view->with('ports',  $ports);
 
	}
}