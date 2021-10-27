<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Libredte;

class TotalConexionSii {

	public function compose(View $view)
	{

        $sii = Libredte::whereDate('created_at', '=', date('Y-m-d'))->first('remaining');
        
        $view->with('sii',  $sii);

	}
}