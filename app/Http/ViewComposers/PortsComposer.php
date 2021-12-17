<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class PortsComposer {

	public function compose(View $view)
	{
		$ports = DB::table('ports')
		->where('type', 'P')
		->select('unlocs', DB::raw("CONCAT(name,' (', unlocs,')') as name_code") )
		->orderBy('name', 'ASC')
		->pluck('name_code','unlocs');

		$currencies = DB::table('currencies')
		->select('code', DB::raw("CONCAT(name,' (', code,')') as name_code"))
		->where('status', '=', true)
		->orderBy('name', 'ASC')
		->pluck('name_code','code');

		$view->with('ports',  $ports);
		$view->with('currencies',  $currencies);
 
	}
}