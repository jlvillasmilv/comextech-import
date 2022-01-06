<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class TransCompaniesComposer {

	public function compose(View $view)
	{
		$trans_companies = DB::table('trans_companies')
		->where('status', true)
		->select('id', 'name')
		->orderBy('name', 'ASC')
		->pluck('name','id');

		$view->with('trans_companies',  $trans_companies);
 
	}
}