<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryService extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'category_services';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(Service::class,'category_service_id');
    }

    public function supplCondSale()
    {
        return $this->belongsToMany(SupplCondSale::class, 'category_service_suppl_cond_sale', 'category_service_id', 'suppl_cond_sale_id');
    }
}
