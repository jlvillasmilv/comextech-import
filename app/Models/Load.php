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

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }

    public function categoryLoad()
    {
        return $this->belongsTo(CategoryLoad::class,'type_load')->withDefault(['name' => '' ]);
    }

    public function container()
    {
        return $this->belongsTo(CategoryContainer::class,'type_container')->withDefault(['name' => '' ]);
    }
}
