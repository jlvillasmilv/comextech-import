<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationCondSale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'application_cond_sales';
    protected $guarded = ['services'];

    protected $hidden = [
        'deleted_at',
        'updated_at',
        'user_id',
        'modified_user_id'
    ];

    public function services()
    {
        return $this->belongsToMany(CategoryService::class, 'category_service_suppl_cond_sale', 'application_cond_sale_id', 'category_service_id')
        ->select('category_services.id','category_services.name', 'category_services.code', 'category_service_suppl_cond_sale.selected' , 'category_services.icon',  \DB::raw("false as checked") )
        ->where('status', true);
    }
}
