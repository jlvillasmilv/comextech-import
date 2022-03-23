<?php

namespace App\Http\Livewire\Client;

use App\Models\{ Application, ApplicationPayment};
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AccountStatementTable extends LivewireDatatable
{
    public $model = ApplicationPayment::class;

    public function builder()
    {
        $application  = Application::where('user_id', auth()->user()->id)->get()->pluck('id');
       
       
        return ApplicationPayment::whereIn('application_id', $application);

    }

    public function columns()
    {
        $table = [

            DateColumn::name('created_at')
            ->label('Fecha'),

            Column::name('application.code')
            ->label('Referencia'),

            Column::name('payment_method_type')
            ->label('Tipo'),

            Column::name('total')
            ->label('CARGO'),
           
        ];

        return $table;
        
    }
}