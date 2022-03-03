<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'company_id', 'rut', 'email', 'first_name', 'last_name', 'address', 'status'
    ];

    protected $table = 'factoring_partners';

    private $full_name_attribute;
    private $format_rut_attribute;

    protected $appends = ['full_name','format_rut'];

    public function getFullNameAttribute()
    {
        return  $this->first_name . ' ' . $this->last_name;
    }

    public function getFormatRutAttribute()
    {
        // if(strlen($this->rut) > 8){
        //     $rut = explode("-", $this->rut);
        //     return number_format(substr($rut[0], 0, 8),0,",",".").'-'.$rut[1];
        // }
        return $this->rut;
       
    }

    public function company()
    {
        return $this->belongsTo(App\Models\Company::class,'company_id');
    }
}
