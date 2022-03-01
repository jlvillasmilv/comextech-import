<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\HasAdvancedFilter;

class Company extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    protected $table = 'companies';
    protected $fillable = [
        'user_id',
        'executive_id',
        'country_id',
        'tax_id',
        'name',
        'email',
        'phone',
        'contact_name',
        'contact_telf',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $orderable = [
        'id',
        'executive_id',
        'tax_id',
        'name',
        'email',
    ];

    public $filterable = [
        'id',
        'tax_id',
        'name',
        'email',
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault(['name' => '']);
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function address()
    {
        return $this->hasMany(CompanyAddress::class,'company_id');
    }

    /**
     * Get the partner associated with the company.
    */
    public function partners()
    {
        return $this->hasMany(Factoring\Partner::class,'company_id');
    }

    public function executive()
    {
        return $this->belongsTo(User::class,'executive_id');
    }

}
