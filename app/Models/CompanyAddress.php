<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table   = 'company_addresses';
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

