<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationDetail extends Model
{
    use HasFactory;

    protected $table = 'application_details';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id')->withDefault(['code' => '', 'symbol' => '' ]);
    }

    public function currency2()
    {
        return $this->belongsTo(Currency::class,'currency2_id')->withDefault(['code' => '', 'symbol' => '' ]);
    }
}
