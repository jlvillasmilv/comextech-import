<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'user_id', 'bank_id', 'number', 'status'
    ];

    protected $table = 'bank_accounts';

    /**
     * Get the Bank associated with the BankAccount.
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get the client associated with the BankAccount.
     */
    public function client()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function disbursement()
    {
        return $this->hasMany(Factoring\Disbursement::class,'bank_accounts_id');
    }
}
