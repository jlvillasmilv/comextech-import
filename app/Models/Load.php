<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    use HasFactory;

    protected $table = 'loads';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function transport()
    {
        return $this->belongsTo(Transport::class,'transport_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryLoad::class,'category_load_id');
    }

    public function container()
    {
        return $this->belongsTo(CategoryContainer::class,'category_container_id');
    }
}
