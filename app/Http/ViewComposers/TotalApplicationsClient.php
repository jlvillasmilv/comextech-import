<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Factoring\Application;

class TotalApplicationsClient {

	public function compose(View $view)
	{

        if(auth()->user()->hasRole('Client')) {

            $application = Application::where('user_id', auth()->user()->id)->count();

            $aprobadas = Application::where([
                ['status', '=', 'Aprobada'],
                ['user_id', auth()->user()->id],
            ])->count();
    
            $proceso = Application::where([
                ['status', '=', 'En Proceso'],
                ['user_id', auth()->user()->id],
            ])->count();
    
            $rechazada = Application::where([
                ['status', '=', 'Rechazada'],
                ['user_id', auth()->user()->id],
            ])->count();
        }
        else{

            $application = Application::count();
            $aprobadas = Application::where('status', '=', 'Aprobada')->count();
            $proceso = Application::where('status', '=', 'En Proceso')->count();
            $rechazada = Application::where('status', '=', 'Rechazada')->count();
        }

        $view->with('application',  $application);
        $view->with('aprobadas',  $aprobadas);
        $view->with('proceso',  $proceso);
        $view->with('rechazada',  $rechazada);
 

	}
}