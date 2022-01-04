<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateLCE extends Model
{
    protected $table   = 'rate_lce';
    protected $guarded = [];
    public $timestamps = false;

    public function transCompany()
    {
        return $this->belongsTo(TransCompany::class,'trans_company_id');
    }
}
