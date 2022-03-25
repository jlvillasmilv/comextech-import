<?php

namespace App\Http\Livewire\Client;

use App\Models\CompanyAccountStatement;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CompanyAccountStatementTable extends LivewireDatatable
{
    
    public function builder()
    {
        return CompanyAccountStatement::where('company_id', auth()->user()->company->id);
    }

    public function columns()
    {
        $table = [

            DateColumn::name('movement_date')
            ->filterable()
            ->label('Fecha'),

            Column::name('reference')
            ->searchable()
            ->label('Referencia'),

            Column::name('method_type')
            ->searchable()
            ->label('Tipo'),

            NumberColumn::name('credit')
            ->label('ABONO'),

            NumberColumn::name('debit')
            ->label('CARGO'),
        ];

        return $table;
        
    }

}