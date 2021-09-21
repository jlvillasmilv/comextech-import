<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationSummary extends Model
{
    use HasFactory;

    protected $table = 'application_summaries';

    public $timestamps = false;

    protected $guarded = [];

    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }
}
