<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryContainer extends Model
{
    use HasFactory;
    protected $table = 'category_containers';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
