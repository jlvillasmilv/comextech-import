<?php

namespace App\Http\Livewire\Client;

use App\Models\{Application, ApplicationPayment};
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AccountStatementTable extends LivewireDatatable
{
    public $model = ApplicationPayment::class;
    public $exportable = true;
    public function builder()
    {
        $application  = Application::where('user_id', auth()->user()->id)->get()->pluck('id');
       
        return ApplicationPayment::join('applications', 'application_payments.application_id', '=', 'applications.id')
        ->select('application_payments.*','applications.code')
        ->whereIn('application_id', $application);

    }

    public function columns()
    {
        $table = [

            DateColumn::name('created_at')
            ->label('Fecha'),

            Column::name('applications.code')
            ->searchable()
            ->label('Referencia'),

            Column::name('payment_method_type')
            ->searchable()
            ->label('Tipo'),

            NumberColumn::name('total')
            ->label('CARGO'),
        ];

        return $table;
        
    }

}