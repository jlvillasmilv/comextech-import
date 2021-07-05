<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplCondSale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'suppl_cond_sales';
    protected $guarded = [];

    protected $hidden = [
        'deleted_at',
        'updated_at',
        'user_id',
        'modified_user_id'
    ];

    public function services()
    {
        return $this->belongsToMany(CategoryService::class, 'category_service_suppl_cond_sale', 'suppl_cond_sale_id', 'category_service_id')
        ->select('category_services.id','category_services.name', \DB::raw("false as selected"));
    }
}
