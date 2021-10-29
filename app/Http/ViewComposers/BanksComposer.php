<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;

class BanksComposer {

	public function compose(View $view)
	{
		$banks = Bank::OrderBy('name')
		->select('id', 'name')
		->orderBy('name', 'ASC')
		->pluck('name','id');

		$view->with('banks',  $banks);
 
	}
}