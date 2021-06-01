<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementsApplication extends Model
{
    use HasFactory;

    protected $table = 'requirements_applications';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class,'requirement_id');
    }
    
}


