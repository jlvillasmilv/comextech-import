<?php

namespace App\Http\Livewire\Client;

use App\Models\{Application, ApplicationPayment};
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ApplicationsTable extends LivewireDatatable
{
    public $model = Application::class;

    public function builder()
    {
        $application  = Application::query()->where('user_id', auth()->user()->id)->get()->pluck('id');
       
        return ApplicationPayment::join('applications', 'application_payments.application_id', '=', 'applications.id')
        ->select('application_payments.*','applications.code')
        ->whereIn('application_id', $application);

    }

    public function columns()
    {
        //
    }
}