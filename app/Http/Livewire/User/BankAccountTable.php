<?php

namespace App\Http\Livewire\User;

use App\Models\{BankAccount,Bank};
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class BankAccountTable extends LivewireDatatable
{
    public $model = BankAccount::class;

    public function builder()
    {

        return BankAccount::where('user_id', auth()->user()->id);
       
    }

    public function columns()
    {
        $table = [

            Column::name('bank.name')
            ->label('Banco')
            ->searchable(),

            Column::name('number')
            ->defaultSort('asc')
            ->searchable()
            ->label('Numero'),

            DateColumn::name('created_at')
            ->searchable()
            ->label('Fecha de Registro'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'bank-accounts.', 'delete' => true]);
            })
        ];

        return $table;
        
    }

    public function getBanksProperty()
    {
        return Bank::pluck('name');
    }
}