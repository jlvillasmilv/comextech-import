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

    public function category()
    {
        return $this->belongsTo(CategoryService::class, 'category_service_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id')->withDefault(['code' => '', 'symbol' => '' ]);
    }
}
