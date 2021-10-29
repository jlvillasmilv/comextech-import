<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name', 'rut', 'observation', 'status'
    ];

    protected $table = 'banks';

    /**
     * Get the bankAccounts associated with the bank.
     */
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }
}
