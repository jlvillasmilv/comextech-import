<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\HasAdvancedFilter;

class Application extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    protected $table = 'applications';
    protected $fillable = ['user_id',
                           'supplier_id',
                           'application_statuses_id',
                           'currency_id',
                           'description',
                           'estimated_date',
                           'fee1',
                           'fee1_date',
                           'fee2',
                           'fee2_date',
                           'fee3',
                           'fee3_date',
                           'amount',
                           'charge',
                           'commission',
                           'interest',
                           'modified_user_id',
                            ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $orderable = [
        'id',
        'created_at',
    ];

    public $filterable = [
        'id',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(ApplicationDetail::class,'application_id');
    }

    public function requirements()
    {
        return $this->hasMany(RequirementsApplication::class,'application_id');
    }

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'application_statuses_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault(['name' => '' ]);
    }

    

}
