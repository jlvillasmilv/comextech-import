<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternmentProcess extends Model
{
    use HasFactory;

    protected $table = 'internment_processes';

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }

    public function customAgent()
    {
        return $this->belongsTo(CustomAgent::class,'custom_agent_id')->withDefault(['name' => '' ]);
    }

    public function fileStoreInternment()
    {
        return $this->hasMany(FileStoreInternment::class,'internment_id');
    }
}
